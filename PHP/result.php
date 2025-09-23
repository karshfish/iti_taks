<?php
echo "Thank  you " . (($_POST['gender'] === 'male') ? "Mr " : "Ms ") . "{$_POST['firstName']} {$_POST['lastName']} <br>";
echo "Please reviewe your information <br>";
echo "Name  : {$_POST['firstName']} {$_POST['lastName']}<br>";
echo "Addess: {$_POST['address']} {$_POST['Country']}<br>";
echo "Skills: <br>";
foreach ($_POST['skills'] as $s) {
    echo  $s . "<br>";
}
echo "Department: {$_POST['depart']}";
