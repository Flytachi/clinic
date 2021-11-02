<?php

/* 
    My Constants
*/

$PERSONAL = array(
    1 => "Администратор",
    2 => "Менеджер",
    3 => "Бухгалтер",
    4 => "Директор",

    11 => "Врач",
    12 => "Диагност", // Диагностика
    13 => "Лаборант",
    14 => "Физиотерапевт",
    15 => "Анестезиолог",

    21 => "Регистратор",
    22 => "Кассир",
    23 => "Кассир/Регистратор",
    24 => "Аптекарь",
    25 => "Медработник",
);

$print_text_count = 3;
$print_hr_count = 4;


$methods = array(
    1 => "Через рот",
    2 => "Внутримышечный (в/м)",
    3 => "Подкожный (п/к)",
    4 => "Внутривенный (в/в)",
    5 => "Внутривенный капельный (в/в кап)",
    6 => "Ректальный",
    7 => "Вагинальный",
    8 => "Ингаляционный",
    9 => "Поверхностное натирание",
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