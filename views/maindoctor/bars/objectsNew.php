<?php
importModel("Ward");
?>
<div class="mb-3">
	<div class="header-elements-sm-inline">
		<span class="mb-0 text-muted d-block">Объекты</span>
		<h4 class="font-weight-semibold d-block">Информация о объектах</h4>
		<span class="mb-0 text-muted d-block">Сегодня</span>
	</div>
</div>

<div class="row">

    <?php
    $wards = new Ward('w');
    $wards->Data('d.id, d.title')->JoinLEFT('divisions d', 'd.id=w.division_id')->Group('w.division_id');
    $count = count($wards->list());
    ?>

    <?php foreach($wards->list(1) as $ward): ?>

        <div class="col-sm-<?= ($count == 1) ? 12 : 6 ?> col-xl-<?= ($count > 4) ? 3 : 12 / $count ?>">
    
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="font-weight-semibold mb-0 mt-1"><?= $ward->title ?></h6>
                    <div class="text-muted mb-3">Процент свободных мест</div>
                    <div class="svg-center position-relative mb-1" id="progress_percentage_<?= $ward->count ?>"></div>
                </div>
                
                <div class="card-body border-top-0 pt-0">
                    <?php $data = (new Ward('w'))->JoinRIGHT('beds b', 'b.ward_id=w.id')->Where("w.division_id = $ward->id")->get("COUNT(CASE WHEN b.user_id IS NOT NULL THEN 1 ELSE null END) 'close'", "COUNT(CASE WHEN b.user_id IS NULL THEN 1 ELSE null END) 'open'") ?>
                    <div class="row mt-2">
                        <div class="col-4">
                            <div class="text-uppercase font-size-xs">Всего</div>
                            <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                <span id="progress_percentage_<?= $ward->count ?>_all"><?= $data->open + $data->close ?></span>
                            </h5>
                        </div>
                        <div class="col-4">
                            <div class="text-uppercase font-size-xs">Свободные</div>
                            <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                <span id="progress_percentage_<?= $ward->count ?>_open"><?= $data->open ?></span>
                            </h5>
                        </div>
                        <div class="col-4">
                            <div class="text-uppercase font-size-xs">Занятые</div>
                            <h5 class="font-weight-semibold line-height-1 mt-1 mb-0">
                                <span id="progress_percentage_<?= $ward->count ?>_close"><?= $data->close ?></span>
                            </h5>
                        </div>
                    </div>
    
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
                <?php foreach($wards->list(1) as $ward): ?>
                    _progressPercentage("#progress_percentage_<?= $ward->count ?>", 40, 2, "", "", 1);
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
