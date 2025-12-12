<?php
ob_start();
foreach ($comptabilite->getMonnaies() as $value) 
{
    $tbMonnaie[] = $value->libelle;
}
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-xl-12">
		<div class="card">
		    <div class="card-body">
		    	<div class="row page-titles">
            <div class="col-md-5 align-self-center">
            </div>
            <div class="col-md-7 align-self-center">
              <div class="d-flex justify-content-end align-items-center"> 
              	<ol class="breadcrumb">
                  <!--<a href="<=WEBROOT?>prevision_report_print" class="btn btn-chocolate text-white d-none d-lg-block m-l-15">Generer pdf</a>-->
                  <button type="button" class="btn btn-chocolate font-light text-white" onclick="submitPrintPrevisionReportForm()">Generer pdf</button>
                </ol>
              </div>
            </div>
          </div>
		        <div class="table-responsive m-t-5">
		            <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		                <thead>
	                    <tr>
	                      <th>ID</th>
                        <th>NOM</th>
                        <?php
                        for($i = 0;$i < $nbmonth;$i++)
                        {
                          $date = new DateTime(date('Y').'-'.$start_month.'-01');
                          $date->add(new DateInterval('P'.$i.'M'));
                        ?>
                          <th><?=$months[intval($date->format('m'))]?></th>
                        <?php
                        }
                        ?>
	                    </tr>
		                </thead>
		                <tfoot>
	                    <tr>
                        <th>ID</th>
                        <th>NOM</th>
                        <?php
                        for($i = 0;$i < $nbmonth;$i++)
                        {
                          $date = new DateTime(date('Y').'-'.$start_month.'-01');
                          $date->add(new DateInterval('P'.$i.'M'));
                        ?>
                          <th><?=$months[intval($date->format('m'))]?></th>
                        <?php
                        }
                        ?>
	                    </tr>
		                </tfoot>
		                <tbody id="retour">
                      <?php
                      foreach ($customer_previsions as $value)
                      {
                      ?>
                        <tr>
                          <td><?=$value->billing_number?></td>
                          <td><?=$value->nom_client?></td>
                          <?php
                          $next_billing_date = $value->next_billing_date;
                          for($i = 0;$i < $nbmonth;$i++)
                          {
                            $date = new DateTime(date('Y').'-'.$start_month.'-01');
                            $date->add(new DateInterval('P'.$i.'M'));
                            $mensualite = 0;

                            if ($next_billing_date <= date('Y-'.$date->format('m').'-01') || $next_billing_date == "") 
                            {
                              $billing_date = new DateTime($next_billing_date);
                              $next_billing_date = $billing_date->add(new DateInterval('P'.$value->facturation.'M'))->format('Y-m-01');
                              $mensualite = $value->montant;
                            }
                          ?>
                            <td><?=number_format($mensualite);?></td>
                          <?php
                            $months_total[intval($date->format('m'))] += $value->monnaie == 'USD' ?$mensualite * 1765 : $mensualite;
                          }
                          ?>
                        </tr>
                      <?php
                      }
                      ?>
		                </tbody>
		            </table>
		        </div>
            <?php
              $graph_data = '';
              foreach ($months_total as $key => $value) 
              {
                $montant = round($value);
                $graph_data .= "{y:'".$months[$key]."',a:".$montant."}, ";
              }
              $graph_data = substr($graph_data, 0,-2);
              /*for($i = 0;$i < $nbmonth;$i++)
              {
                $date = new DateTime(date('Y').'-'.$start_month.'-01');
                $date->add(new DateInterval('P'.$i.'M'));
                echo $months_total[intval($date->format('m'))]."</br>";
              }*/
            ?>
		    </div>
		</div>
	</div>
</div>
<form id="print_prevision_report_form" action="<?=WEBROOT?>prevision_report_print" method="post">
  <input type="hidden" name="report_data" value="<?php echo serialize($months_total)?>">
</form>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <span id="msg">GRAPH DE PREVISION</span>
      </div>
      <div class="card-body">
        <h6 class="card-title"></h6>
        <div id="graph_prevision_data"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    var graph_prevision_data = [<?= $graph_data;?>];
</script>
<?php
$home_admin_content = ob_get_clean();
require_once('vue/admin/home.admin.php');
?>