<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

$test_name = 'Krupenko Alexey Vikttorovich';
$test_name1 = 'КРУПЕНКО';
$test_name2 = 'АЛЕКСЕЙ';
$test_name3 = 'ВИКТОРОВИЧ';

function getFullnameFromParts($s_name, $n_name, $p_name)
{
    return $s_name . ' ' . $n_name . ' ' . $p_name;
}
echo "getFullnameFromParts принимает как аргумент три строки — фамилию, имя и отчество. Возвращает как результат их же, но склеенные через пробел.\n";
echo (getFullnameFromParts($test_name1, $test_name2, $test_name3));
echo "\n";
echo "\n";

function getPartsFromFullname($s)
{

    $r = explode(" ", $s);
    $fin = ['surname' => $r[0], 'name' => $r[1], 'patronomyc' => $r[2]];
    return $fin;
}

echo "getPartsFromFullname принимает как аргумент одну строку — склеенное ФИО. Возвращает как результат массив из трёх элементов с ключами ‘name’, ‘surname’ и ‘patronomyc’.\n";
print_r(getPartsFromFullname($example_persons_array[1]['fullname']));
echo "\n";
echo "\n";

function getShortName($s)
{
    $tmp = getPartsFromFullname($s);
    $res = $tmp['surname'] . " " . mb_substr($tmp['name'], 0, 1) . ".";
    return $res;
}
echo "getShortName, принимает как аргумент строку, содержащую ФИО вида «Иванов Иван Иванович» и возвращающую строку вида «Иван И.»\n";
echo (getShortName($example_persons_array[2]['fullname']));
echo "\n";
echo "\n";

// Разработайте функцию getGenderFromName, принимающую как аргумент строку, содержащую ФИО (вида «Иванов Иван Иванович»). 
// после проверок всех признаков, если «суммарный признак пола» больше нуля — возвращаем 1 (мужской пол);
// после проверок всех признаков, если «суммарный признак пола» меньше нуля — возвращаем -1 (женский пол);
// после проверок всех признаков, если «суммарный признак пола» равен 0 — возвращаем 0 (неопределенный пол).

function getGenderFromName($s)
{
    $indicator = 0;
    $tmp = getPartsFromFullname($s);
    //отчество
    $tmp_man = $tmp['patronomyc'];
    if (mb_substr($tmp_man, mb_strlen($tmp_man) - 2, 2) == 'ич') {
        $indicator += 1;
    }
    if (mb_substr($tmp_man, mb_strlen($tmp_man) - 3, 3) == 'вна') {
        $indicator -= 1;
    }
    // echo ($indicator);
    // echo "\n";
    //имя    
    $tmp_man = $tmp['name'];
    if ((mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'й') || (mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'н')) {
        $indicator += 1;
    }
    if ((mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'а') || (mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'я')) {
        $indicator -= 1;
    }
    // echo ($indicator);
    // echo "\n";
    //фамилия
    $tmp_man = $tmp['surname'];
    if ((mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'в') || (mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'н')) {
        $indicator += 1;
    }
    if ((mb_substr($tmp_man, mb_strlen($tmp_man) - 2, 2) == 'ва') || (mb_substr($tmp_man, mb_strlen($tmp_man) - 2, 2) == 'ая')) {
        $indicator -= 1;
    }
    // echo ($indicator);
    // echo "\n";

    if ($indicator > 0) {
        return 'мужской пол';
    } elseif ($indicator < 0) {
        return 'женский пол';
    } else {
        return 'неопределенный пол';
    }
};

echo "Разработайте функцию getGenderFromName\n";
echo (getGenderFromName($example_persons_array[1]['fullname']));

// Определение возрастно-полового состава
// Обработка массивов, арифметика, обработка строк
// В админском интерфейсе требуется выводить половой состав аудитории.

// Напишите функцию getGenderDescription для определения полового состава аудитории. Как аргумент в функцию передается массив, схожий по структуре с массивом $example_persons_array. Как результат функции возвращается информация в следующем виде:

// Гендерный состав аудитории:
// ---------------------------
// Мужчины - 55.5%
// Женщины - 35.5%
// Не удалось определить - 10.0%
// Используйте для решения функцию фильтрации элементов массива, функцию подсчета элементов массива, функцию getGenderFromName, округление.

function getGenderDescription($a)
{
    $tmp_man = 0;
    $tmp_woman = 0;
    $tmp_uncertain = 0;

    foreach ($a as $key => $value) {
        if (getGenderFromName($value['fullname']) == 'мужской пол') {
            $tmp_man += 1;
        } elseif (getGenderFromName($value['fullname']) == 'женский пол') {
            $tmp_woman += 1;
        }
    }
    $tmp_man = round($tmp_man/count($a)*100);
    echo "Мужской пол = $tmp_man".' %';
    echo "\n";
    $tmp_woman = round($tmp_woman/count($a)*100);
    echo "Женский пол = $tmp_woman".' %';
    echo "\n";
    echo "Не удалось определить = ".round(100-$tmp_man-$tmp_woman).' %';
    echo "\n";
}
echo "\n";
echo "\n";
echo "Напишите функцию getGenderDescription для определения полового состава аудитории.\n";
getGenderDescription($example_persons_array);


// приводим фамилию, имя, отчество (переданных первыми тремя аргументами) к привычному регистру;
// склеиваем ФИО, используя функцию getFullnameFromParts;
// определяем пол для ФИО с помощью функции getGenderFromName;
// случайным образом выбираем любого человека в массиве;
// проверяем с помощью getGenderFromName, что выбранное из Массива ФИО - противоположного пола, если нет, то возвращаемся к шагу 4, если да - возвращаем информацию.
// Как результат функции возвращается информация в следующем виде:

// Иван И. + Наталья С. = 
// ♡ Идеально на 64.43% ♡
// Процент совместимости «Идеально на ...» — случайное число от 50% до 100% с точностью два знака после запятой.

echo "\n";
echo "\n";
function getPerfectPartner($name1,$name2,$name3,$a)
{
    $name1 = mb_convert_case($name1, MB_CASE_TITLE, "UTF-8");
    $name2 = mb_convert_case($name2, MB_CASE_TITLE, "UTF-8");
    $name3 = mb_convert_case($name3, MB_CASE_TITLE, "UTF-8");
  
    $test_name = getFullnameFromParts($name1,$name2,$name3);
    $test_name_gender1 = getGenderFromName($test_name);
    // echo "$test_name_gender1\n";
    $rand_key = array_rand($a, 1);
    // echo "выбрали\n";
    $test_name2 = $a[$rand_key]['fullname'];
    // echo "определили пол\n";
    $test_name_gender2 = getGenderFromName($test_name2);
    // echo "$test_name_gender2\n";

    while ($test_name_gender2 != 'женский пол')
    {
        $rand_key = array_rand($a, 1);
        $test_name2 = $a[$rand_key]['fullname'];
        $test_name_gender2 = getGenderFromName($test_name2);
        // echo "$test_name_gender2\n";
    }
    echo "пара совпала \n";
    echo getShortName($test_name)." + ".getShortName($test_name2)." = \n";
    $rand = round(rand(5000,10000)/100,2);
    echo "♡ Идеально на $rand % ♡";
    
}

echo "Напишите функцию getPerfectPartner для определения «идеальной» пары.\n";
$test_name1 = 'КРУПЕНКО';
$test_name2 = 'АЛЕКСЕЙ';
$test_name3 = 'ВиКтОрОвИч';
getPerfectPartner($test_name1,$test_name2,$test_name3,$example_persons_array);


