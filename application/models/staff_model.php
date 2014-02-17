<?php
class staff_model extends CI_Model{

    // Maurice,
    // 
    // I moved all the functions here into either the items model or the orders model, depending.
    // I did so because each one was centric to either items or orders. 
    // For example, it makes sense that the unshipped_orders function be in the orders model.
    // A similar argument goes for the rest. I think it also makes sense that our models reflect our DB tables.
    // I modified your controller code to reflect this change. Don't be too offended ;-)
    // 
    // - Michael

    // unshipped_orders     -> orders_model
    // shipped_orders       -> orders_model
    // weekly_best_sellers  -> orders_model
    // best_sellers_to_date -> orders_model

    // is_in_stock      -> items_model
    // low_inventory    -> items_model
    // related_items    -> items_model
}
?>