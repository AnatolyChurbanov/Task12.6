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
?>

<?php
function getPartsFromFullName ($fullName) {
    $personsName = ["name", "surname", "patronomyc"];
    return array_combine ($personsName, explode(' ', $fullName));
}

echo 'Результат разбиения ФИО на части:' . "<br>";
$arrParts = getPartsFromFullname($example_persons_array[6]['fullname']);
print_r($arrParts);
echo "<br>"."<br>";
?>

<?php
function getFullnameFromParts ($surname, $name, $patronomyc) {
    return $surname .= ' ' . $name . ' ' . $patronomyc;
}
echo 'Результат объединения ФИО из частей:'. "<br>";
$arrFullName = getFullNameFromParts ($arrParts['name'], $arrParts['surname'], $arrParts['patronomyc']);
print_r ($arrFullName);
echo "<br>"."<br>";
?>

<?php
function getShortName ($fullName) {
    $shortedName = getPartsFromFullname ($fullName);
    return $shortedName['name']. ' ' .mb_substr($shortedName['surname'], 0, 1). '.';
}
echo 'Результат сокращения ФИО:' . "<br>";
$shortedName = getShortName($example_persons_array[6]['fullname']);
print_r($shortedName);
echo "<br>"."<br>";
?>

<?php
function getGenderFromName ($fullName) {
    $shortedName = getPartsFromFullName ($fullName);
    $gender = 0;
    if (mb_substr($shortedName['surname'], -1, 1) == 'ва') {
        --$gender;
    }
    if (mb_substr($shortedName['name'], -2, 2) == 'а') {
        --$gender;
    }
    if (mb_substr($shortedName['patronomyc'], -3, 3) == 'вна') {
        --$gender;
    }
    if (mb_substr($shortedName['surname'], -1, 1) == 'в') {
        ++$gender;
    }
    if (mb_substr($shortedName['name'], -2, 2) == 'й' || (mb_substr($shortedName['name'], -2, 2) == 'н')) {
        ++$gender;
    }
    if (mb_substr($shortedName['patronomyc'], -3, 3) == 'вич') {
        ++$gender;
    } 
    switch($gender <=> 0){
        case 1:
            return 'Мужчина';
            break;
        case -1:
            return 'Женщина';
            break;
        default:
            return'Не удалось определить';
    }   
}
for ($i=0; $i<count($example_persons_array); $i++){
    $arrGender[$example_persons_array[$i]['fullname']] = getGenderFromName($example_persons_array[$i]['fullname']);
}

echo "Результат функции определения пола по ФИО: ". "<br>";
print_r($arrGender);
echo "<br>"."<br>";
?>

<?php
    // Подсчет кол-ва мужчин, женщин и не определенного пола
    function getGenderDescription ($arrGender, $arrLength) {
        $countMale = 0;
        $countFemale = 0;
        $countUnknown = 0;
        // Подсчет кол-ва мужчин, женщин и не определенного пола

        foreach($arrGender as $value) { 
            if ($value == 1){$countMale++;}
            if ($value == -1){$countFemale++;}
            if ($value == 0){$countUnknown++;}
            echo ($value);
        }
        
        // Процентное определение из всего количества человек
        $malePercent = round((($countMale)/($arrLength))*100, 1);
        $femalePercent = round((($countFemale)/($arrLength))*100, 1);
        $unknownPercent = round((($countUnknown)/($arrLength))*100, 1);
        echo "Гендерный состав аудитории:" . "<br>";
        echo "--------------------------------------" . "<br>";
        echo "Мужчины" . " " . "-" . " " . $malePercent . "%" . "<br>";
        echo "Женщины" . " " . "-" . " " . $femalePercent . "%" . "<br>";
        echo "Не удалось определить" . " " . "-" . " " . $unknownPercent . "%" . "<br>";
    }

getGenderDescription ($arrGender, $arrLength = count($example_persons_array));  
?>