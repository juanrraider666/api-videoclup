<?php
/*----------------------------------------------------------------------
|:                                                                    :|
|:  Tarea adicional prueba tecn.                                      :|
|:  ===========================                                       :|
|: Implementar una función que ordene un array de arrays. La función  :|
|: recibirá dos parámetros,                                           :|
|: el primero con el array a ordenar, y el segundo parámetro será otro:|
|: array con el criterio deordenación, donde la key de cada elemento  :|
|: de este segundo array indicará sobre que propiedad hay que ordenar :|
|: y el  valor de cada elemento indicará la dirección de              :|
|: ordenamiento (ascendente(ASC) o descendente (DESC)).               :|
|:                                                                    :|
|:                                                                    :|
----------------------------------------------------------------------*/

declare(strict_types=1);


$users = [
    ['name' => 'Oscar', 'age' => 18, 'scoring' => 40],
    ['name' => 'Mario', 'age' => 45, 'scoring' => 10],
    ['name' => 'Zuleta', 'age' => 33, 'scoring' => -78],
    ['name' => 'Mario', 'age' => 45, 'scoring' => 78],
    ['name' => 'Patricio', 'age' => 22, 'scoring' => 9],
];

//With sort
$orderBy = ['age' => 'desc', 'scoring' => 'desc'];

//Empty sort
//$orderBy = [];

orderArray($users, $orderBy);


function orderArray(array $criteria, ?array $orderBy = null)
{
    if ($orderBy) {
        setOrderBy($orderBy, $criteria);
    }

    echo('RESULT::').PHP_EOL;
    print_r($criteria);
}

function setOrderBy(array $orderBy, &$criteria)
{
    $orderByList = [];

    foreach ($orderBy as $fieldName => $orientation) {
        $orientation = strtoupper(trim($orientation));

        if ($orientation !== 'ASC' && $orientation !== 'DESC') {
            echo 'WARN, Invalid order by orientation specified for field' . $fieldName.PHP_EOL;
        }

        if (isset($fieldName)) {
            $orderByList[] = $fieldName . ' ' . $orientation;

            if($orientation === 'ASC') {
                $orientation = SORT_ASC;
                array_multisort(array_column($criteria, $fieldName), $orientation, $criteria);

            }

            if($orientation === 'DESC') {
                $orientation = SORT_DESC;
                //todo: Warn. No le va importar como esta ordenando anteriormente.
                array_multisort(array_column($criteria, $fieldName), $orientation, $criteria);
            }

            continue;

        }

        echo sprintf('Unrecognized field: %s', $fieldName).PHP_EOL;
    }

    echo ' ORDER BY ' . implode(', ', $orderByList).PHP_EOL;

}
