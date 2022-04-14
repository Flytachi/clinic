<?php

/* 
    My Constants
*/


$PERSONAL = array(
    1 => "Администратор",
    2 => "Регистратура",
    3 => "Кассир",
    4 => "Аптекарь",
    5 => "Врач",
    6 => "Лаборатория",
    7 => "Медсестра",
    8 => "Главный врач",
    9 => "Кухня",
    10 => "Диагностика",
    11 => "Анестезиолог",
    12 => "Физиотерапия",
    13 => "Процедурная",
    14 => "Опер Блок",
    32 => "Касса-Регистратура",
);

$print_text_count = 3;
$print_hr_count = 4;

$PHARM_VISION = [4,5,7];

$CATEGORY = array(
    2 => "Лекарства",
    3 => "Расходные материалы",
    4 => "Наркотические вещества",
);

$classes = array(
    // Layouts
    "navbar" => "navbar navbar-expand-md navbar-dark bg-primary navbar-static", //fixed-top
    "sidebar" => "sidebar sidebar-light sidebar-main sidebar-expand-md",
    "header" => "page-header page-header-light",
    "footer" => "navbar navbar-expand-lg navbar-light",

    // Error
    "error_page-code-color" => "",

    // Cards
    "card" => "card border-1 border-primary",
    "card-header" => "card-header text-dark header-elements-inline alpha-primary",
    "card-filter" => "card border-1 border-violet",
    "card-filter_header" => "card-header text-dark header-elements-inline alpha-violet",
    "card-filter_btn" => "btn btn-outline bg-violet text-violet border-violet btn-sm legitRipple",
    
    // Forms
    "form-select" => "form-control form-control-select2",
    "form-select_price" => "form-control myselect",
    "form-multiselect" => "form-control multiselect-full-featured",
    "form-daterange" => "form-control daterange-locale",
    
    // Buttons
    // "btn-completed" => "btn btn-outline bg-purple text-purple border-purple btn-sm legitRipple",
    "btn-icd" => "btn btn-outline bg-pink text-pink border-pink btn-sm legitRipple",
    "btn-completed" => "btn btn-outline-danger btn-sm legitRipple",
    "btn-journal" => "btn btn-outline-primary btn-sm legitRipple",
    "btn-price" => "btn btn-outline-primary btn-sm legitRipple",
    "btn-detail" => "btn btn-outline-primary btn-sm legitRipple",
    "btn-viewing" => "btn btn-outline-primary btn-sm legitRipple",
    "btn-diagnostic_finally" => "btn btn-outline-primary btn-sm legitRipple",
    "btn-table" => "btn btn-dark btn-sm legitRipple",
    "btn-render" => "btn btn-dark btn-sm legitRipple",
        // Cashbox 
        "price_btn-sale" => "btn btn-outline-secondary btn-sm legitRipple",
        "price_btn-prepayment" => "btn btn-outline-success btn-sm legitRipple",
        "price_btn-refund" => "btn btn-outline-danger btn-sm legitRipple",
        "price_btn-finish" => "btn btn-outline-warning btn-sm legitRipple",
        "price_btn-detail" => "btn btn-outline-dark btn-sm legitRipple",
    
    // Modals
    "modal-global_content" => "modal-content border-3 border-primary",
    "modal-global_header" => "modal-header bg-primary",
    "modal-global_btn_close" => "btn btn-outline-primary btn-sm legitRipple", // btn-link

    "modal-session_content" => "modal-content border-3 border-success",
    "modal-session_header" => "modal-header bg-success",
    "modal-session_btn_logout" => "btn btn-outline-danger btn-sm legitRipple", // btn-link
    "modal-session_btn_confirm" => "btn btn-outline-success btn-sm legitRipple", // btn-link
    
    // Others
    "input-search" => "form-control border-primary wmin-200",
    "input-service_search" => "form-control border-primary wmin-200 mb-2",
    "input-product_search" => "form-control border-teal wmin-200 mb-2",
    "table-thead" => "bg-primary",
    "table-count_menu" => "table-primary",

    "table_detail-thead" => "bg-dark",
    "table_detail-count_menu" => "table-secondary",

)
?>