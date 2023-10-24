<?php

return [
    'string' => 'Поле ":attribute" должно быть строкой',
    'numeric' => 'Поле ":attribute" должно быть числом',
    'integer' => 'Поле ":attribute" должно иметь тип integer',
    'required_with' => 'Поле ":attribute" обязательно, когда присутствует ":values"',
    'gte' => [
        'numeric' => 'Значение поля ":attribute" должно быть больше или равно :value',
    ],
    'attributes' => [
        'price.min' => 'мин.цена',
        'price.max' => 'макс.цена',
        'length' => 'длина',
        'weight' => 'вес',
        'width' => 'ширина',
        'height' => 'высота',
        'length_unit' => 'единицы длины',
        'weight_unit' => 'единицы веса',
        'width_unit' => 'единицы ширины',
        'height_unit' => 'единицы высоты',
    ],
];
