<?php
    $ef = $_SESSION["effet"];
    $attrib = "";
    $classeCoef = "";

    switch ($ef->attribut) {
        case "sante":
            $attrib = "Santé";
            $classeCoef = ($ef->coef < 0 ? "mauvais" : "bon");
            break;

        case "bonheur":
            $attrib = "Bonheur";
            $classeCoef = ($ef->coef < 0 ? "mauvais" : "bon");
            break;

        case "faim":
            $attrib = "Faim";
            $classeCoef = ($ef->coef > 0 ? "mauvais" : "bon");
            break;

        case "maladie":
            $attrib = "Maladie";
            $classeCoef = ($ef->coef > 0 ? "mauvais" : "bon");
            break;
    }
?>
    <li>
        <?php echo $attrib; ?>
        <span class="<?php echo $classeCoef; ?>">
            <?php echo ($ef->coef > 0 ? "+" : "") . $ef->coef; ?>
        </span>
    </li>
