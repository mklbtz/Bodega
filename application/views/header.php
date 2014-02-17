<?php
$this->load->helper('url');

// Various URLs
$home = site_url('/home');
$cart = site_url('/cart');
$orders = site_url('/orders');
$logout = site_url('/logout');
$login = site_url('/login');
$staff = site_url('/staff');

// configure dynamic search url
if (isset($controller)) {
    if ($controller == "staff")
        $search = '/staff/inventory/';
    else $search = '/home/browse/';
}
else $search = '/home/browse/';

if (!empty($category)) { $search = $search . $category; }
else { $search = $search . 'All'; }

$search = site_url($search);

// set random funny placeholder text for search box
if (isset($controller) && $controller == 'staff') {
    $placeholders = array("Inventory Search");
}
else $placeholders = array("Wow me into searching!", "Search-o-matic", "Search-tastsic!", "We do cavity searches", "Search us, or we'll search you...", 
                             "Search like TSA", "Search", "No peeking", "U search bro?", "Keep calm and search on.", "Search and Siezure");

$placeholder = $placeholders[array_rand($placeholders)];

// get user data from DB
$email = $this->session->userdata('email');
if (!empty($email)) {
    $q = "SELECT * FROM bodega_customers WHERE email = '{$email}';";
    $results = $this->db->query($q);
    $results = $results->result_array();
    if (!empty($results)) {
        $user = $results[0];
    }
    else $user = false;
}
else $user = false;
?>

<div id="header">

    <h1 class="header"><a class="header" href="<?php echo $home ?>">Bodega</a></h1>

    <div id="search">
        <form action="<?php echo $search; ?>" method="GET">
            <input class="search_field" type="text" name="search" placeholder="<?php echo $placeholder; ?>"
                value="<?php if (!empty($searchTerms )) echo implode(" ", $searchTerms); ?>"/>
            <input type="submit" value="Search"/>
        </form>
    </div>

    <ul class="user_controls">
        <?php if(!empty($user)): ?>
        <li class="user_controls"><?php echo "Hey, " . $user['first_name'] . "!"; ?></li>
        <li class="user_controls"><a href="<?php echo $cart; ?>">Cart</a></li>
        <li class="user_controls"><a href="<?php echo $orders; ?>">Orders</a></li>

        <?php if($user['staff'] == "1"): ?>
        <li class="user_controls"><a href="<?php echo $staff; ?>">Staff</a></li>
        <?php endif; ?>

        <li class="user_controls"><a href="<?php echo $logout; ?>">Logout</a></li>

        <?php else: ?>
        <li class="user_controls"><a href="<?php echo $login; ?>">Login</a></li>
    <?php endif; ?> 
    </ul>

</div>