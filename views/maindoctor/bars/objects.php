<?php
require_once '../../../tools/warframe.php';
$session->is_auth(8);

$buildings = (new Table($db, "buildings"))->get_table();
$count = count($buildings);
?>
<div class="mb-3">
	<div class="header-elements-sm-inline">
		<span class="mb-0 text-muted d-block">Объекты</span>
		<h4 class="font-weight-semibold d-block">Информация о объектах</h4>
		<span class="mb-0 text-muted d-block">Сегодня</span>
	</div>
</div>

<div class="row">

    <?php foreach($buildings as $building): ?>
        <?php $opens=$closes=0;?>
        <div class="col-sm-<?= ($count == 1) ? 12 : 6 ?> col-xl-<?= ($count > 4) ? 3 : 12 / $count ?>">
    
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="font-weight-semibold mb-0 mt-1"><?= $building->name ?></h6>
                    <div class="text-muted mb-3">Процент свободных мест</div>
                    <div class="svg-center position-relative mb-1" id="progress_percentage_<?= $building->id ?>"></div>
                </div>
    
                <div class="card-body border-top-0 pt-0">
    
                    <?php for($fl=1; $fl <= $building->floors; $fl++): ?>
                        <?php
                        $opens += $open = $db->query("SELECT * FROM beds WHERE building_id = $building->id AND floor = $fl AND patient_id IS NULL")->rowCount();
                        $closes += $close = $db->query("SELECT * FROM beds WHERE building_id = $building->id AND floor = $fl AND patient_id IS NOT NULL")->rowCount();
                        ?>
                        <div class="row mt-2">
                            <div class="col-12"><?= $fl ?> этаж</div>
        
                            <div class="col-4">
                                <div class="text-uppercase font-size-xs">Всего</div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                    <?= $open+$close ?>
                                </h5>
                            </div>
                            <div class="col-4">
                                <div class="text-uppercase font-size-xs">Свободные</div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                    <?= $open ?>
                                </h5>
                            </div>
                            <div class="col-4">
                                <div class="text-uppercase font-size-xs">Занятые</div>
                                <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                    <?= $close ?>
                                </h5>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <span style="display:none" id="progress_percentage_<?= $building->id ?>_all"><?= $opens+$closes ?></span>
                    <span style="display:none" id="progress_percentage_<?= $building->id ?>_open"><?= $opens ?></span>
                    <span style="display:none" id="progress_percentage_<?= $building->id ?>_close"><?= $closes ?></span>
    
                </div>
            </div>
    
        </div>
    <?php endforeach; ?>

</div>

<script>

    // Setup module
    // ------------------------------

    var StatisticWidgets = (function () {
        //
        // Setup module components
        //

        // Animated progress with percentage count
        var _progressPercentage = function (
            element,
            radius,
            border,
            backgroundColor,
            foregroundColor,
            end
        ) {
            if (typeof d3 == "undefined") {
                console.warn("Warning - d3.min.js is not loaded.");
                return;
            }

            // Initialize chart only if element exsists in the DOM
            if (element) {
                // Basic my func
                // ------------------------------
                if ($(element + "_all").text()) {
                    var all = Number($(element + "_all").text());
                    var open = Number($(element + "_open").text());
                    var close = Number($(element + "_close").text());
                    if (open == all) {
                        end = 1;
                    } else if (close == all) {
                        end = 0;
                        backgroundColor = "#f11";
                    } else {
                        end = open / all;
                    }
                }

                if (!foregroundColor) {
                    if (end >= 0.6) {
                        foregroundColor = "#2196F3";
                    } else if (end >= 0.3) {
                        foregroundColor = "#f91";
                    } else {
                        foregroundColor = "#f11";
                    }
                }

                if (!backgroundColor) {
                    backgroundColor = "#eee";
                }

                // Basic setup
                // ------------------------------

                // Main variables
                var d3Container = d3.select(element),
                    startPercent = 0,
                    fontSize = 22,
                    endPercent = end,
                    twoPi = Math.PI * 2,
                    formatPercent = d3.format(".0%"),
                    boxSize = radius * 2;

                // Values count
                var count = Math.abs((endPercent - startPercent) / 0.01);

                // Values step
                var step = endPercent < startPercent ? -0.01 : 0.01;

                // Create chart
                // ------------------------------

                // Add SVG element
                var container = d3Container.append("svg");

                // Add SVG group
                var svg = container
                    .attr("width", boxSize)
                    .attr("height", boxSize)
                    .append("g")
                    .attr("transform", "translate(" + radius + "," + radius + ")");

                // Construct chart layout
                // ------------------------------

                // Arc
                var arc = d3.svg
                    .arc()
                    .startAngle(0)
                    .innerRadius(radius)
                    .outerRadius(radius - border)
                    .cornerRadius(20);

                //
                // Append chart elements
                //

                // Paths
                // ------------------------------

                // Background path
                svg.append("path")
                    .attr("class", "d3-progress-background")
                    .attr("d", arc.endAngle(twoPi))
                    .style("fill", backgroundColor);

                // Foreground path
                var foreground = svg
                    .append("path")
                    .attr("class", "d3-progress-foreground")
                    .attr("filter", "url(#blur)")
                    .style({
                        fill: foregroundColor,
                        stroke: foregroundColor,
                    });

                // Front path
                var front = svg
                    .append("path")
                    .attr("class", "d3-progress-front")
                    .style({
                        fill: foregroundColor,
                        "fill-opacity": 1,
                    });

                // Text
                // ------------------------------

                // Percentage text value
                var numberText = svg
                    .append("text")
                    .attr("dx", 0)
                    .attr("dy", fontSize / 2 - border)
                    .style({
                        "font-size": fontSize + "px",
                        "line-height": 1,
                        fill: foregroundColor,
                        "text-anchor": "middle",
                    });

                // Animation
                // ------------------------------

                // Animate path
                function updateProgress(progress) {
                    foreground.attr("d", arc.endAngle(twoPi * progress));
                    front.attr("d", arc.endAngle(twoPi * progress));
                    numberText.text(formatPercent(progress));
                }

                // Animate text
                var progress = startPercent;
                (function loops() {
                    updateProgress(progress);
                    if (count > 0) {
                        count--;
                        progress += step;
                        setTimeout(loops, 10);
                    }
                })();
            }
        };

        //
        // Return objects assigned to module
        //

        return {
            init: function () {
                <?php foreach($buildings as $building): ?>
                    _progressPercentage("#progress_percentage_<?= $building->id ?>", 60, 4, "", "", 1);
                <?php endforeach; ?>
            },
        };
    })();

    // Initialize module
    // ------------------------------

    // When content loaded
    document.addEventListener("DOMContentLoaded", function () {
        StatisticWidgets.init();
    });

</script>
