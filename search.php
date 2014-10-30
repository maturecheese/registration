<html>
    <head>
    <Title>Registration Form</Title>
        <style type="text/css">
            body {
                background-color: #fff;

                color: #333;
                font-size: .85em;
                margin: 20;
                padding: 20;
                font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
            }

            h1, h2, h3, {
                color: #000;
                margin-bottom: 0;
                padding-bottom: 0;
            }

            h1 {
                font-size: 2em;
            }

            h2 {
                font-size: 1.75em;
            }

            h3 {
                font-size: 1.2em;
            }

            table {
                margin-top: 0.75em;
            }

            th {
                font-size: 1.2em;
                text-align: left;
                border: none;
                padding-left: 0;
            }

            td {
                padding: 0.25em 2em 0.25em 0em;
                border: 0 none;
            }
        </style>
    </head>

<?php
require_once 'login.php';



echo <<<_END


        <body>
            <h1>Search Table</h1>
            Back to <a href='index.php'>Main</a>
            <form method="post" action="search.php" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Search table entries by name :</td>
                        <td><input type="text" name="searchName"></td>

                    </tr>
                    <tr>
                        <td>Search table entries by email :</td>
                        <td><input type="text" name="searchEmail"></td>

                    </tr>
                </table>
                <input type="submit" name='submit' value='Submit'>
            </form>




_END;


$resultsNeeded=false;
if(!empty($_POST)){
    if (strlen($_POST['searchName'])> 2 || strlen($_POST['searchEmail'])>2){
        $searchName = $_POST['searchName'];
        $searchEmail = $_POST['searchEmail'];
        $resultsNeeded = true;
    }else{
        echo "<span style='color: red'>* search query must be longer than 2 characters</span>";



}
if($resultsNeeded){
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die(var_dump($e));
    }
    if(strlen($searchName)> 2 && strlen($searchEmail)> 2){
        $sql_select = "     SELECT * FROM registration_tbl
                            WHERE name LIKE '%$searchName%'
                            OR email LIKE '%$searchEmail%'";
    }elseif(strlen($searchName)> 2 ){
        $sql_select = "     SELECT * FROM registration_tbl
                            WHERE name LIKE '%$searchName%'";
    }else{
        $sql_select = "     SELECT * FROM registration_tbl
                            WHERE email LIKE '%$searchEmail%'";
    }
    $PdoStatement = $conn->query($sql_select);
    $registrants = $PdoStatement->fetchAll();
    if (count($registrants)>0){
        echo "<h2> Results</h2><br>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Date</th>";
        echo "<th>Company Name</th></tr>";
        foreach ($registrants as $registrant){
            echo "<tr><td>" . $registrant['name'] . "</td>";
            echo "<td>" . $registrant['email'] . "</td>";
            echo "<td>" . $registrant['date'] . "</td>";
            echo "<td>" . $registrant['companyname'] . "</td></tr>";
        }
        echo "</table>";
    }else{
        echo "No Matching results";
    }

}
     echo '</body></html>';
}

?>
