<?php
require_once("../../model/connection.php");
require_once("../../model/contract.class.php");

$contract = new Contract();

$j = 0;
foreach ($contract->getFactureNonPayerDunClient($_POST['result']) as $value) 
{
	if ($value->reste > 0 ) 
		$montant = round($value->reste);
	else
		$montant = round($value->montant);
?>
	<option value="<?=$value->facture_id.'='.$montant.'='.$value->monnaie.'='.$value->exchange_rate.'='.$value->mois_debut.'='.$value->annee.'='.$value->billing_date?>">
		<?php echo 'No '.$value->numero.', mois: '.$value->mois_debut.'/'.$value->annee.', montant: '.$montant.' '.$value->monnaie.', taux: '.$value->exchange_rate?>
	</option>
    <!--<tr> 
        <td>
        	<label class="btn">
		        <input type="checkbox" id="facturepaye<?=$j?>" value="<=$value->facture_id.'-'.$montant.'-'.$value->monnaie.'-'.$value->exchange_rate.'-'.$value->mois_debut.'-'.$value->annee?>" onclick="showHideInputMontantOnPayement(this,'<?=$j?>')"> <php echo 'No '.$value->numero.', mois: '.$value->mois_debut.'/'.$value->annee.', montant: '.$montant.' '.$value->monnaie.', taux: '.$value->exchange_rate?>
		    </label>
		</td>
        <td>
            <div id="champtext<?=$j?>" style="display: none;">
                <input type="number" min="1" id="montant<?=$j?>" class="form-control form-control-sm">
            </div>
        </td>
    </tr>-->
<?php
	//$j++;
}
?>
<!--<tr>
	<td><input type="text" id="nombreFacture" value="<?=$j?>" hidden></td>
	<td></td>
</tr>-->
