<?php header('Content-type: image/svg+xml'); ?>
<?xml version="1.0"?>
<svg width="44" height="100" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg">
    <g transform="scale(1.5)">
        <title>Marker</title>
        <path fill="#<?php echo $_GET['ColorAC']; ?>" fill-opacity="0.4"
              stroke-miterlimit="10" stroke="black" stroke-width="0.5" stroke-opacity="1"
              d="m10.99797,40.59101c-2,-20 -10,-22 -10,-30a10,10 0 1 1 20,0c0,8 -8,10 -10,30z"/>
        <text font-weight="bold" xml:space="preserve" text-anchor="middle"
              font-family="Sans-serif" font-size="8" y="14" x="10.5"
              fill="#<?php echo $_GET['ColorPS']; ?>" ><?php echo intval($_GET['PSNo']); ?></text>
    </g>
</svg>