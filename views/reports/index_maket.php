<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Отчёты";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include layout('sidebar') ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include layout('header') ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

                <div class="card">
					<div class="card-header">
						<h5 class="card-title">Sitemap</h5>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-sm-6 col-lg-3">
								<div class="mb-3">
									<h6 class="font-weight-semibold">Main</h6>
									<ul class="list list-unstyled">
										<li><a href="index.html">Dashboard</a></li>
										<li><a href="../../RTL/default/index.html">RTL version</a></li>
										<li><a href="changelog.html">Changelog</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Starter kit</h6>
									<ul class="list list-unstyled">
										<li><a href="starters/horizontal_nav.html">Horizontal navigation</a></li>
										<li><a href="starters/1_col.html">1 column</a></li>
										<li><a href="starters/2_col.html">2 columns</a></li>
										<li><a href="starters/3_col_dual.html">3 columns - Dual sidebars</a></li>
										<li><a href="starters/3_col_double.html">3 columns - Double sidebars</a></li>
										<li><a href="starters/4_col.html">4 columns</a></li>
										<li><a href="starters/detached_left.html">Detached layout - Left sidebar</a></li>
										<li><a href="starters/detached_right.html">Detached layout - Right sidebar</a></li>
										<li><a href="starters/detached_sticky.html">Detached layout - Sticky sidebar</a></li>
										<li><a href="starters/layout_boxed.html">Boxed layout</a></li>
										<li><a href="starters/layout_navbar_fixed_main.html">Fixed main navbar</a></li>
										<li><a href="starters/layout_navbar_fixed_secondary.html">Fixed secondary navbar</a></li>
										<li><a href="starters/layout_navbar_fixed_both.html">Both navbars fixed</a></li>
										<li><a href="starters/layout_fixed.html">Fixed layout</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Editors</h6>
									<ul class="list list-unstyled">
										<li><a href="editor_summernote.html">Summernote editor</a></li>
										<li><a href="editor_ckeditor.html">CKEditor</a></li>
										<li><a href="editor_trumbowyg.html">Trumbowyg editor</a></li>
										<li><a href="editor_code.html">Code editor</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Content appearance</h6>
									<ul class="list list-unstyled">
										<li><a href="appearance_content_cards.html">Content cards</a></li>
										<li><a href="appearance_card_heading.html">Card heading elements</a></li>
										<li><a href="appearance_card_footer.html">Card footer elements</a></li>
										<li><a href="appearance_draggable_cards.html">Draggable cards</a></li>
										<li><a href="appearance_text_styling.html">Text styling</a></li>
										<li><a href="appearance_typography.html">Typography</a></li>
										<li><a href="appearance_helpers.html">Helper classes</a></li>
										<li><a href="appearance_syntax_highlighter.html">Syntax highlighter</a></li>
										<li><a href="appearance_content_grid.html">Grid system</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Sidebars</h6>
									<ul class="list list-unstyled">
										<li><a href="sidebar_default_collapse.html">Default collapsible</a></li>
										<li><a href="sidebar_default_hide.html">Default hideable</a></li>
										<li><a href="sidebar_mini_collapse.html">Mini collapsible</a></li>
										<li><a href="sidebar_mini_hide.html">Mini hideable</a></li>
										<li><a href="sidebar_dual.html">Dual sidebar</a></li>
										<li><a href="sidebar_dual_double_collapse.html">Dual double collapse</a></li>
										<li><a href="sidebar_dual_double_hide.html">Dual double hide</a></li>
										<li><a href="sidebar_dual_swap.html">Swap sidebars</a></li>
										<li><a href="sidebar_double_collapse.html">Double - Collapse main sidebar</a></li>
										<li><a href="sidebar_double_hide.html">Double - Hide main sidebar</a></li>
										<li><a href="sidebar_double_fix_default.html">Double - Fix default width</a></li>
										<li><a href="sidebar_double_fix_mini.html">Double - Fix mini width</a></li>
										<li><a href="sidebar_double_visible.html">Double - Opposite sidebar visible</a></li>
										<li><a href="sidebar_detached_left.html">Detached - Left position</a></li>
										<li><a href="sidebar_detached_right.html">Detached - Right position</a></li>
										<li><a href="sidebar_detached_sticky_custom.html">Detached - Sticky (custom scroll)</a></li>
										<li><a href="sidebar_detached_sticky_native.html">Detached - Sticky (native scroll)</a></li>
										<li><a href="sidebar_detached_separate.html">Detached - Separate categories</a></li>
										<li><a href="sidebar_hidden.html">Hidden sidebar</a></li>
										<li><a href="sidebar_light.html">Light sidebar</a></li>
										<li><a href="sidebar_components.html">Sidebar components</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Echarts library</h6>
									<ul class="list list-unstyled">
										<li><a href="echarts_lines_areas.html">Lines and areas</a></li>
										<li><a href="echarts_columns_waterfalls.html">Columns and waterfalls</a></li>
										<li><a href="echarts_bars_tornados.html">Bars and tornados</a></li>
										<li><a href="echarts_scatter.html">Scatter charts</a></li>
										<li><a href="echarts_pies_donuts.html">Pies and donuts</a></li>
										<li><a href="echarts_funnels_chords.html">Funnels and chords</a></li>
										<li><a href="echarts_candlesticks_others.html">Candlesticks and others</a></li>
										<li><a href="echarts_combinations.html">Chart combinations</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Google library</h6>
									<ul class="list list-unstyled">
										<li><a href="google_lines.html">Line charts</a></li>
										<li><a href="google_bars.html">Bar charts</a></li>
										<li><a href="google_pies.html">Pie charts</a></li>
										<li><a href="google_scatter_bubble.html">Bubble &amp; scatter charts</a></li>
										<li><a href="google_other.html">Other charts</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">File uploaders</h6>
									<ul class="list list-unstyled">
										<li><a href="uploader_plupload.html">Plupload</a></li>
										<li><a href="uploader_bootstrap.html">Bootstrap file uploader</a></li>
										<li><a href="uploader_dropzone.html">Dropzone</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Data tables</h6>
									<ul class="list list-unstyled">
										<li><a href="datatable_basic.html">Basic initialization</a></li>
										<li><a href="datatable_styling.html">Basic styling</a></li>
										<li><a href="datatable_advanced.html">Advanced examples</a></li>
										<li><a href="datatable_sorting.html">Sorting options</a></li>
										<li><a href="datatable_api.html">Using API</a></li>
										<li><a href="datatable_data_sources.html">Data sources</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">User pages</h6>
									<ul class="list list-unstyled">
										<li><a href="user_list.html">User list</a></li>
										<li><a href="user_profile.html">Simple profile</a></li>
										<li><a href="user_profile_tabbed.html">Tabbed profile</a></li>
										<li><a href="user_profile_cover.html">Profile with cover</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Learning</h6>
									<ul class="list list-unstyled">
										<li><a href="learning_list.html">List view</a></li>
										<li><a href="learning_grid.html">Grid view</a></li>
										<li><a href="learning_detailed.html">Detailed course</a></li>
									</ul>
								</div>
							</div>

							<div class="col-sm-6 col-lg-3">
								<div class="mb-3">
									<h6 class="font-weight-semibold">Page layouts</h6>
									<ul class="list list-unstyled">
										<li><a href="layout_navbar_fixed.html">Fixed navbar</a></li>
										<li><a href="layout_navbar_sidebar_fixed.html">Fixed navbar &amp; sidebar</a></li>
										<li><a href="layout_sidebar_fixed_native.html">Fixed sidebar native scroll</a></li>
										<li><a href="layout_navbar_hideable.html">Hideable navbar</a></li>
										<li><a href="layout_footer_fixed.html">Fixed footer</a></li>
										<li><a href="boxed_default.html">Boxed with default sidebar</a></li>
										<li><a href="boxed_mini.html">Boxed with mini sidebar</a></li>
										<li><a href="boxed_full.html">Boxed full width</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Form components</h6>
									<ul class="list list-unstyled">
										<li><a href="form_inputs_basic.html">Basic inputs</a></li>
										<li><a href="form_checkboxes_radios.html">Checkboxes &amp; radios</a></li>
										<li><a href="form_input_groups.html">Input groups</a></li>
										<li><a href="form_controls_extended.html">Extended controls</a></li>
										<li><a href="form_floating_labels.html">Floating labels</a></li>
										<li><a href="form_select2.html">Select2 selects</a></li>
										<li><a href="form_multiselect.html">Bootstrap multiselect</a></li>
										<li><a href="form_tag_inputs.html">Tag inputs</a></li>
										<li><a href="form_dual_listboxes.html">Dual Listboxes</a></li>
										<li><a href="form_editable.html">Editable forms</a></li>
										<li><a href="form_validation.html">Validation</a></li>
										<li><a href="form_inputs_grid.html">Inputs grid</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Pickers</h6>
									<ul class="list list-unstyled">
										<li><a href="picker_date.html">Date &amp; time pickers</a></li>
										<li><a href="picker_color.html">Color pickers</a></li>
										<li><a href="picker_location.html">Location pickers</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Extra components</h6>
									<ul class="list list-unstyled">
										<li><a href="extra_sliders_noui.html">NoUI sliders</a></li>
										<li><a href="extra_sliders_ion.html">Ion range sliders</a></li>
										<li><a href="extra_session_timeout.html">Session timeout</a></li>
										<li><a href="extra_idle_timeout.html">Idle timeout</a></li>
										<li><a href="extra_trees.html">Dynamic tree views</a></li>
										<li><a href="extra_context_menu.html">Context menu</a></li>
										<li><a href="extra_fab.html">Floating action buttons</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Vertical navigation</h6>
									<ul class="list list-unstyled">
										<li><a href="navigation_vertical_collapsible.html">Collapsible menu</a></li>
										<li><a href="navigation_vertical_accordion.html">Accordion menu</a></li>
										<li><a href="navigation_vertical_sizing.html">Navigation sizing</a></li>
										<li><a href="navigation_vertical_bordered.html">Bordered navigation</a></li>
										<li><a href="navigation_vertical_right_icons.html">Right icons</a></li>
										<li><a href="navigation_vertical_labels_badges.html">Labels and badges</a></li>
										<li><a href="navigation_vertical_disabled.html">Disabled navigation links</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">D3 library</h6>
									<ul class="list list-unstyled">
										<li><a href="d3_lines_basic.html">Simple lines</a></li>
										<li><a href="d3_lines_advanced.html">Advanced lines</a></li>
										<li><a href="d3_bars_basic.html">Simple bars</a></li>
										<li><a href="d3_bars_advanced.html">Advanced bars</a></li>
										<li><a href="d3_pies.html">Pie charts</a></li>
										<li><a href="d3_circle_diagrams.html">Circle diagrams</a></li>
										<li><a href="d3_tree.html">Tree layout</a></li>
										<li><a href="d3_other.html">Other charts</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Maps</h6>
									<ul class="list list-unstyled">
										<li><a href="maps_google_basic.html">Google - Basics</a></li>
										<li><a href="maps_google_controls.html">Google - Controls</a></li>
										<li><a href="maps_google_markers.html">Google - Markers</a></li>
										<li><a href="maps_google_drawings.html">Google - Map drawings</a></li>
										<li><a href="maps_google_layers.html">Google - Layers</a></li>
										<li><a href="maps_vector.html">Vector maps</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Event calendars</h6>
									<ul class="list list-unstyled">
										<li><a href="extension_fullcalendar_views.html">Basic views</a></li>
										<li><a href="extension_fullcalendar_styling.html">Event styling</a></li>
										<li><a href="extension_fullcalendar_formats.html">Language and time</a></li>
										<li><a href="extension_fullcalendar_advanced.html">Advanced usage</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Data tables extensions</h6>
									<ul class="list list-unstyled">
										<li><a href="datatable_extension_reorder.html">Columns reorder</a></li>
										<li><a href="datatable_extension_row_reorder.html">Row reorder</a></li>
										<li><a href="datatable_extension_fixed_columns.html">Fixed columns</a></li>
										<li><a href="datatable_extension_fixed_header.html">Fixed header</a></li>
										<li><a href="datatable_extension_autofill.html">Auto fill</a></li>
										<li><a href="datatable_extension_key_table.html">Key table</a></li>
										<li><a href="datatable_extension_scroller.html">Scroller</a></li>
										<li><a href="datatable_extension_select.html">Select</a></li>
										<li><a href="datatable_extension_buttons_init.html">Buttons - Initialization</a></li>
										<li><a href="datatable_extension_buttons_flash.html">Buttons - Flash buttons</a></li>
										<li><a href="datatable_extension_buttons_print.html">Buttons - Print buttons</a></li>
										<li><a href="datatable_extension_buttons_html5.html">Buttons - HTML5 buttons</a></li>
										<li><a href="datatable_extension_colvis.html">Columns visibility</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">General pages</h6>
									<ul class="list list-unstyled">
										<li><a href="general_news.html">News</a></li>
										<li><a href="general_feed.html">Feed</a></li>
										<li><a href="general_widgets_content.html">Content widgets</a></li>
										<li><a href="general_widgets_stats.html">Statistics widgets</a></li>
										<li><a href="general_embeds.html">Embeds</a></li>
										<li><a href="general_faq.html">FAQ page</a></li>
										<li><a href="general_knowledgebase.html">Knowledgebase</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Timelines</h6>
									<ul class="list list-unstyled">
										<li><a href="timelines_left.html">Left timeline</a></li>
										<li><a href="timelines_right.html">Right timeline</a></li>
										<li><a href="timelines_center.html">Centered timeline</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Search</h6>
									<ul class="list list-unstyled">
										<li><a href="search_basic.html">Basic search results</a></li>
										<li><a href="search_users.html">User search results</a></li>
										<li><a href="search_images.html">Image search results</a></li>
										<li><a href="search_videos.html">Video search results</a></li>
									</ul>
								</div>
							</div>

							<div class="col-sm-6 col-lg-3">
								<div class="mb-3">
									<h6 class="font-weight-semibold">Layouts</h6>
									<ul class="list list-unstyled">
										<li><a href="../../../layout_1/LTR/index.html" id="layout1">Layout 1</a></li>
										<li><a href="index.html" id="layout2">Layout 2</a></li>
										<li><a href="../../../layout_3/LTR/index.html" id="layout3">Layout 3</a></li>
										<li><a href="../../../layout_4/LTR/index.html" id="layout4">Layout 4</a></li>
										<li><a href="../../../layout_5/LTR/index.html" id="layout5">Layout 5</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">JSON forms</h6>
									<ul class="list list-unstyled">
										<li><a href="alpaca_basic.html">Basic inputs</a></li>
										<li><a href="alpaca_advanced.html">Advanced inputs</a></li>
										<li><a href="alpaca_controls.html">Controls</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Form layouts</h6>
									<ul class="list list-unstyled">
										<li><a href="form_layout_vertical.html">Vertical form</a></li>
										<li><a href="form_layout_horizontal.html">Horizontal form</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Animations</h6>
									<ul class="list list-unstyled">
										<li><a href="animations_css3.html">CSS3 animations</a></li>
										<li><a href="animations_velocity_basic.html">Velocity - Basic usage</a></li>
										<li><a href="animations_velocity_ui.html">Velocity - UI pack effects</a></li>
										<li><a href="animations_velocity_examples.html">Velocity - Advanced examples</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Horizontal navigation</h6>
									<ul class="list list-unstyled">
										<li><a href="navigation_horizontal_click.html">Submenu on click</a></li>
										<li><a href="navigation_horizontal_hover.html">Submenu on hover</a></li>
										<li><a href="navigation_horizontal_elements.html">With custom elements</a></li>
										<li><a href="navigation_horizontal_tabs.html">Tabbed navigation</a></li>
										<li><a href="navigation_horizontal_disabled.html">Disabled navigation links</a></li>
										<li><a href="navigation_horizontal_mega.html">Horizontal mega menu</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Dimple library</h6>
									<ul class="list list-unstyled">
										<li><a href="dimple_lines_horizontal.html">Lines - Horizontal orientation</a></li>
										<li><a href="dimple_lines_vertical.html">Lines - Vertical orientation</a></li>
										<li><a href="dimple_bars_horizontal.html">Bars - Horizontal orientation</a></li>
										<li><a href="dimple_bars_vertical.html">Bars - Vertical orientation</a></li>
										<li><a href="dimple_area_horizontal.html">Area - Horizontal orientation</a></li>
										<li><a href="dimple_area_vertical.html">Area - Vertical orientation</a></li>
										<li><a href="dimple_step_horizontal.html">Step - Horizontal orientation</a></li>
										<li><a href="dimple_step_vertical.html">Step - Vertical orientation</a></li>
										<li><a href="dimple_pies.html">Pie charts</a></li>
										<li><a href="dimple_rings.html">Ring charts</a></li>
										<li><a href="dimple_scatter.html">Scatter charts</a></li>
										<li><a href="dimple_bubble.html">Bubble charts</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Extensions</h6>
									<ul class="list list-unstyled">
										<li><a href="extension_image_cropper.html">Image cropper</a></li>
										<li><a href="extension_blockui.html">Block UI</a></li>
										<li><a href="extension_dnd.html">Drag and drop</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Internationalization</h6>
									<ul class="list list-unstyled">
										<li><a href="internationalization_switch_direct.html">Direct translation</a></li>
										<li><a href="internationalization_switch_query.html">Querystring parameter</a></li>
										<li><a href="internationalization_on_init.html">Set language on init</a></li>
										<li><a href="internationalization_after_init.html">Set language after init</a></li>
										<li><a href="internationalization_fallback.html">Language fallback</a></li>
										<li><a href="internationalization_callbacks.html">Callbacks</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Handsontable</h6>
									<ul class="list list-unstyled">
										<li><a href="handsontable_basic.html">Basic configuration</a></li>
										<li><a href="handsontable_advanced.html">Advanced setup</a></li>
										<li><a href="handsontable_cols.html">Column features</a></li>
										<li><a href="handsontable_cells.html">Cell features</a></li>
										<li><a href="handsontable_types.html">Basic cell types</a></li>
										<li><a href="handsontable_custom_checks.html">Custom &amp; checkboxes</a></li>
										<li><a href="handsontable_ac_password.html">Autocomplete &amp; password</a></li>
										<li><a href="handsontable_search.html">Search</a></li>
										<li><a href="handsontable_context.html">Context menu</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Blog</h6>
									<ul class="list list-unstyled">
										<li><a href="blog_classic_v.html">Classic vertical</a></li>
										<li><a href="blog_classic_h.html">Classic horizontal</a></li>
										<li><a href="blog_grid.html">Grid</a></li>
										<li><a href="blog_timeline.html">Timeline</a></li>
										<li><a href="blog_single.html">Single post</a></li>
										<li><a href="blog_sidebar_left.html">Left sidebar</a></li>
										<li><a href="blog_sidebar_right.html">Right sidebar</a></li>
										<li><a href="blog_no_sidebar.html">No sidebar</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Authentication</h6>
									<ul class="list list-unstyled">
										<li><a href="login_simple.html">Simple login</a></li>
										<li><a href="login_advanced.html">More login info</a></li>
										<li><a href="login_registration.html">Simple registration</a></li>
										<li><a href="login_registration_advanced.html">More registration info</a></li>
										<li><a href="login_unlock.html">Unlock user</a></li>
										<li><a href="login_password_recover.html">Reset password</a></li>
										<li><a href="login_hide_navbar.html">Hide navbar</a></li>
										<li><a href="login_transparent.html">Transparent box</a></li>
										<li><a href="login_background.html">Background option</a></li>
										<li><a href="login_validation.html">With validation</a></li>
										<li><a href="login_tabbed.html">Tabbed form</a></li>
										<li><a href="login_modals.html">Inside modals</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Error pages</h6>
									<ul class="list list-unstyled">
										<li><a href="error_403.html">Error 403</a></li>
										<li><a href="error_404.html">Error 404</a></li>
										<li><a href="error_405.html">Error 405</a></li>
										<li><a href="error_500.html">Error 500</a></li>
										<li><a href="error_503.html">Error 503</a></li>
										<li><a href="error_offline.html">Offline page</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Ecommerce set</h6>
									<ul class="list list-unstyled">
										<li><a href="ecommerce_product_list.html">Product list</a></li>
										<li><a href="ecommerce_product_grid.html">Product grid</a></li>
										<li><a href="ecommerce_orders_history.html">Orders history</a></li>
										<li><a href="ecommerce_customers.html">Customers</a></li>
										<li><a href="ecommerce_pricing.html">Pricing tables</a></li>
									</ul>
								</div>
							</div>

							<div class="col-sm-6 col-lg-3">
								<div class="mb-3">
									<h6 class="font-weight-semibold">Color system</h6>
									<ul class="list list-unstyled">
										<li><a href="colors_primary.html">Primary palette</a></li>
										<li><a href="colors_danger.html">Danger palette</a></li>
										<li><a href="colors_success.html">Success palette</a></li>
										<li><a href="colors_warning.html">Warning palette</a></li>
										<li><a href="colors_info.html">Info palette</a></li>
										<li><a href="colors_pink.html">Pink palette</a></li>
										<li><a href="colors_violet.html">Violet palette</a></li>
										<li><a href="colors_purple.html">Purple palette</a></li>
										<li><a href="colors_indigo.html">Indigo palette</a></li>
										<li><a href="colors_blue.html">Blue palette</a></li>
										<li><a href="colors_teal.html">Teal palette</a></li>
										<li><a href="colors_green.html">Green palette</a></li>
										<li><a href="colors_orange.html">Orange palette</a></li>
										<li><a href="colors_brown.html">Brown palette</a></li>
										<li><a href="colors_grey.html">Grey palette</a></li>
										<li><a href="colors_slate.html">Slate palette</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Wizards</h6>
									<ul class="list list-unstyled">
										<li><a href="wizard_steps.html">Steps wizard</a></li>
										<li><a href="wizard_form.html">Form wizard</a></li>
										<li><a href="wizard_stepy.html">Stepy wizard</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Components</h6>
									<ul class="list list-unstyled">
										<li><a href="components_modals.html">Modals</a></li>
										<li><a href="components_dropdowns.html">Dropdown menus</a></li>
										<li><a href="components_tabs.html">Tabs component</a></li>
										<li><a href="components_pills.html">Pills component</a></li>
										<li><a href="components_navs.html">Accordion and navs</a></li>
										<li><a href="components_buttons.html">Buttons</a></li>
										<li><a href="components_notifications_pnotify.html">PNotify notifications</a></li>
										<li><a href="components_notifications_others.html">Other notifications</a></li>
										<li><a href="components_popups.html">Tooltips and popovers</a></li>
										<li><a href="components_alerts.html">Alerts</a></li>
										<li><a href="components_pagination.html">Pagination</a></li>
										<li><a href="components_labels.html">Labels and badges</a></li>
										<li><a href="components_loaders.html">Loaders and bars</a></li>
										<li><a href="components_thumbnails.html">Thumbnails</a></li>
										<li><a href="components_page_header.html">Page header</a></li>
										<li><a href="components_breadcrumbs.html">Breadcrumbs</a></li>
										<li><a href="components_media.html">Media objects</a></li>
										<li><a href="components_affix.html">Affix and Scrollspy</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Icons</h6>
									<ul class="list list-unstyled">
										<li><a href="icons_glyphicons.html">Glyphicons</a></li>
										<li><a href="icons_icomoon.html">Icomoon</a></li>
										<li><a href="icons_fontawesome.html">Font awesome</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Navbars</h6>
									<ul class="list list-unstyled">
										<li><a href="navbar_single.html">Single navbar</a></li>
										<li><a href="navbar_multiple_navbar_navbar.html">Multiple - Navbar + navbar</a></li>
										<li><a href="navbar_multiple_navbar_header.html">Multiple - Navbar + header</a></li>
										<li><a href="navbar_multiple_header_navbar.html">Multiple - Header + navbar</a></li>
										<li><a href="navbar_multiple_top_bottom.html">Multiple - Top + bottom</a></li>
										<li><a href="navbar_colors.html">Color options</a></li>
										<li><a href="navbar_sizes.html">Sizing options</a></li>
										<li><a href="navbar_hideable.html">Hide on scroll</a></li>
										<li><a href="navbar_components.html">Navbar components</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">C3 library</h6>
									<ul class="list list-unstyled">
										<li><a href="c3_lines_areas.html">Lines and areas</a></li>
										<li><a href="c3_bars_pies.html">Bars and pies</a></li>
										<li><a href="c3_advanced.html">Advanced examples</a></li>
										<li><a href="c3_axis.html">Chart axis</a></li>
										<li><a href="c3_grid.html">Grid options</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">JQuery UI</h6>
									<ul class="list list-unstyled">
										<li><a href="jqueryui_interactions.html">Interactions</a></li>
										<li><a href="jqueryui_forms.html">Forms</a></li>
										<li><a href="jqueryui_components.html">Components</a></li>
										<li><a href="jqueryui_sliders.html">Sliders</a></li>
										<li><a href="jqueryui_navigation.html">Navigation</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Basic tables</h6>
									<ul class="list list-unstyled">
										<li><a href="table_basic.html">Basic examples</a></li>
										<li><a href="table_sizing.html">Table sizing</a></li>
										<li><a href="table_borders.html">Table borders</a></li>
										<li><a href="table_styling.html">Table styling</a></li>
										<li><a href="table_elements.html">Table elements</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Responsive tables</h6>
									<ul class="list list-unstyled">
										<li><a href="table_responsive.html">Responsive basic tables</a></li>
										<li><a href="datatable_responsive.html">Responsive data tables</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Invoicing</h6>
									<ul class="list list-unstyled">
										<li><a href="invoice_template.html">Invoice template</a></li>
										<li><a href="invoice_grid.html">Invoice grid</a></li>
										<li><a href="invoice_archive.html">Invoice archive</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Task manager</h6>
									<ul class="list list-unstyled">
										<li><a href="task_manager_grid.html">Task grid</a></li>
										<li><a href="task_manager_list.html">Task list</a></li>
										<li><a href="task_manager_detailed.html">Task detailed</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Job search</h6>
									<ul class="list list-unstyled">
										<li><a href="job_list.html">Job list</a></li>
										<li><a href="job_grid.html">Job grid</a></li>
										<li><a href="job_detailed.html">Job detailed</a></li>
										<li><a href="job_apply.html">Apply</a></li>
										<li><a href="job_create.html">Create job</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Conversation set</h6>
									<ul class="list list-unstyled">
										<li><a href="mail_list.html">Mail list</a></li>
										<li><a href="mail_list_detached.html">Mail list (detached)</a></li>
										<li><a href="mail_read.html">Read mail</a></li>
										<li><a href="mail_write.html">Write mail</a></li>
										<li><a href="chat_layouts.html">Chat layouts</a></li>
										<li><a href="chat_options.html">Chat options</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
