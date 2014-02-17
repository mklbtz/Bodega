<link rel="stylesheet" type="text/css" href="icon_font.css">
<style type="text/css">

/***********************/
/**** GLOBAL STYLES ****/
/***********************/
/* COLORS
 * #4F5155 - text grey
 * #D0D0D0 - border grey
 * #F9F9F9 - table alt grey
 * #4F5155 - header grey
 * #003399 - link blue
 * #E13300 - selection red
 */

::selection { background-color: #E13300; color: white; }
::moz-selection { background-color: #E13300; color: white; }
::webkit-selection { background-color: #E13300; color: white; }

code {
    font-family: Consolas, Monaco, Courier New, Courier, monospace;
    font-size: 12px;
    background-color: #f9f9f9;
    border: 1px solid #D0D0D0;
    color: #002166;
    display: block;
    margin: 14px 0 14px 0;
    padding: 12px 10px 12px 10px;
}

body {
    background-color: #fff;
    margin: 40px;
    font: 13px/20px normal Helvetica, Arial, sans-serif;
    color: #4F5155;
}

a {
    color: #003399;
    background-color: transparent;
    font-weight: normal;
}

input[type=text], input[type=password] {
    padding: 5px;
    border: 1px solid #D0D0D0;
    width: 200px;
}

input[type=text].item_count_box {
    width: 30px;
}
input[type=text].item_promo_box{
	width: 30px;
}

#container {
    border: 1px solid #D0D0D0;
    -webkit-box-shadow: 0 0 8px #D0D0D0;
}

.float_right { float: right; }
.float_left { float: left; }
.right_align { text-align: right; }
.center_align { text-align: center;}
.full_width { width: 100%; }
.overflow { overflow: auto; }
.hidden { display: none; }
.no_margin { margin:0; }

.error_message {
    text-align: center;
    color: white;
    background-color: #E13300;
}

.success_message {
    text-align: center;
    color: white;
    background-color: #43BB3E;
}



/*************************/
/**** HEADER & FOOTER ****/
/*************************/

#header {
    height: 50px;
    border-bottom: 1px solid #D0D0D0;
    margin: 0;
    padding: 14px 15px 10px 15px;
}

h1.header {
    color: #444;
    background-color: transparent;
    font-size: 32px;
    font-weight: normal;
    float: left;
    margin-top: 10px;
    margin-left: 5px;
}

ul.user_controls {
    list-style-type: none;
    padding: 0;
    float: right;
    margin-right: 10px;
}

li.user_controls {
    display: inline;
    margin-left: 10px;
}

a.header {
    color: #4f5155;
    background-color: transparent;
    font-weight: bold;
    text-decoration: none;
}

a.header:hover {
    text-decoration: underline;
}

#search {
    margin-top: 8px;
    margin-left: 75px;
    float: left;
}


input.search_field {
    width: 300px;
}

p.footer{
    text-align: right;
    font-size: 11px;
    border-top: 1px solid #D0D0D0;
    line-height: 32px;
    margin: 0;
    padding: 0 10px 0 10px;
}



/***************************/
/**** CONTENT & SIDEBAR ****/
/***************************/

#content {
    padding-left: 20px;
    padding-right: 20px;
}

#sidebar_column {
    width: 130px;
    border-right: 1px solid #D0D0D0;
    vertical-align: top;
}

#main_column {
    vertical-align: top;
}


/********************/
/**** CATEGORIES ****/
/********************/

#categories {
    width: 100%;
}

h3.categories {

}

ul.categories {
    list-style-type: none;
    padding-left: 0;
}

li.category {
    margin-left: 0;
}

li.category.selected {
    color: #000;
    background-color: #F9F9F9;
}


/*******************************/
/**** BROWSE/SEARCH RESULTS ****/
/*******************************/

#browse_table_container {
    width: 100%;
}

#browse_table_row{
    height: 100px;
}

#browse_items_image{
    float: left;
    max-height: 100%;
}

#browse_items_row_middle{
    float: left;
    margin-left: 20px;
    margin-right: 20px;
}

#browse_items_row_right{
    float: right;
    padding-right: 10px;
    padding-top: 30px;
}

tr.browse_tr_style {
    background-color: #FFF;

}

tr.browse_tr_alt_style {
    background-color: #F9F9F9;
}

table.browse_table {
    width: 100%;
}

p.strikeout {
    text-decoration: line-through;
}

p.promo {
    color: green;
    font-size: 15px;
}

/********************/
/**** ITEMS PAGE ****/
/********************/

#item_image_price_container {
    margin-top: 10px;
    overflow: auto;
}

#item_image_container {
    float: left;
    margin-bottom: 10px;
}

img.item_image {
    max-height: 170px;
}

#item_overview {
    width: auto;
    min-width: 170px;
    height: 170px;
    margin: 0px 10px 10px 10px;
    padding: 0px 10px 0px 10px ;
    float: left;
    overflow: auto;
    border: 1px;
    border-color: #D0D0D0;
    border-style: solid;
}

#item_price_container {
    float: left;
}

#item_savings {
    float: left;
}

#details {

}

table.item_details {
    border: none;
    padding: 12px 10px 12px 10px;
}

td.item_row_head {
    text-align: right;
    font-style: bold;
    vertical-align: top;
}


#related_items_container {
    overflow: auto;
    margin: 0 0 20px 0;
}

.related_item {
    float: left;
    padding: 9px 9px 9px 9px ;
    margin: 0 10px 0 10px;
    border: 1px solid #D0D0D0;
}

.related_item_image {
    max-height: 150px;
    float: left;
}

.related_item_title {
    text-align: center;
}



/*******************/
/**** CART PAGE ****/
/*******************/



/****************************/
/**** UNFULFILLED ORDERS ****/
/****************************/

#orders_table_row{
    height: 35px;
}

tr.orders_tr_style {
    background-color: #FFF;

}

tr.orders_tr_alt_style {
    background-color: #F9F9F9;
}

p.order_description {
    margin-left: 20px;
    margin-right: 20px;
}

#item_list_table {
    margin-bottom: 20px;
}

.item_list_cells {
    padding: 0 20px 0 0;
    /*text-align: center;*/
}

.fulfill_button {
    margin-bottom: 20px;
}

/***********************/
/***** STAFF DASH ******/
/***********************/

#low_inventory_dash{
	text-align: center;
	border: 1px solid #D0D0D0;
	float: center;
	margin: 9px 15% 9px 15%;
	padding: 9px 9px 9px 9px;
	width: 70%;
}
#unshipped_orders_dash{

	border: 1px solid #D0D0D0;
	margin: 9px 15% 9px 15%;
	float: center;
	padding: 9px 9px 9px 9px;
	width: 70%;
}
#weekly_best_dash{
	margin: 9px 15% 9px 15%;
	border: 1px solid #D0D0D0;
	float: center;
	padding: 9px 9px 9px 9px;
	width: 70%;
}

th.upc, th.stock{
	width: 5%;
}
th.title{
	width: 40%;
}

</style>
