<?php
return [
    1 => function () {
        return 2;
    },
    2 => null,
    3 => function ($value, $rowData, $rowIndex) {
        if ($value == 23) {
            return $rowIndex + 5;
        }
        if ($rowData[0] == 101) {
            return 0;
        }
        return 2;
    },
];
