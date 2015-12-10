<?php
/**
 * Created by Digital Media.
 * User: Benyamin Maengkom
 * Date: 12/10/15
 * Time: 2:37 PM
 */

include('Connection.php');
include('TaxCalculator.php');

use TaxCalc\TaxCalculator;

// Declaration
$inputValue = 0;
$alert = "";
$objectToCalculate = new TaxCalculator();

// CHeck if there are value submitted from a form
if (isset($_POST['valueToCut'])) $inputValue = $_POST['valueToCut'];

// Cannot calculate value < 0
if ($inputValue < 0) {
    $alert = '<div class="alert alert-danger" role="alert">You cannot input value less than zero!</div>';
    $inputValue = 0;
}

// Calculate
$valueToCut = $objectToCalculate->getValueToCut($inputValue);
$rules = $objectToCalculate->getTaxRules();

?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tax Calculator</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
    </head>
    <body>
    <div class="container">
        <h1>Tax Calculator 2015</h1>
        <hr/>
        <div class="row">
            <form action="index.php" method="post">
                <div class="form-group col-md-6">
                    <?php echo $alert; ?>
                    <div class="input-group">
                        <input type="text" class="form-control" name="valueToCut" placeholder="Type your value here...">
                <span class="input-group-btn">
                    <button type="submit" class="inline btn btn-primary">Submit</button>
                </span>
                    </div>
                </div>
            </form>
        </div>

        <table class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>No</th>
                    <th>Range</th>
                    <th>Value to cut</th>
                    <th>Tax %</th>
                    <th><span class="pull-right">Result</span></th>
                </tr>
                <?php
                $i = 1;
                $total = 0;
                foreach ($rules as $item) {

                    // How much tax for each rule apply ?
                    $result = $item['percent'] * $valueToCut[$item['id']] * 0.01;

                    // Total tax should be paid
                    $total += $result;

                    echo "<tr>";
                    echo "    <td>" . $i . "</td>";

                    if ($item['max_value'] != -1) {
                        if ($i == 1)
                            echo "    <td>0 - " . number_format($item['max_value']) . "</td>";
                        else
                            echo "    <td>" . number_format($max_value) . " - " . number_format($item['max_value']) . "</td>";
                    } else {
                        echo "    <td> > " . number_format($max_value) . "</td>";
                    }

                    echo "    <td>" . number_format($valueToCut[$item['id']]) . "</td>";
                    echo "    <td>" . $item['percent'] . "</td>";
                    echo "    <td><span class=\"pull-right\">" . number_format($result) . "</span></td>";
                    echo "</tr>";

                    $max_value = $item['max_value'];
                    $i++;
                }

                ?>
            </table>
        </table>

        <div class="row text-right">
            <div class="col-xs-2 col-xs-offset-8">
                <p>
                    <strong>
                        Total :
                    </strong>
                </p>
            </div>
            <div class="col-xs-2">
                <strong><?php echo number_format($total); ?></strong>
            </div>
        </div>
    </div>
    </body>
    </html>
