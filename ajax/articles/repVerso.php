  <?php 
            $i = 0;
            foreach($article->getVersoArticle() as $value)
            {
                 $i++;
            ?>
            <tr>
                  
                   
                    <td><?php echo $value->titre?></td>
                    <td><?php echo iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value->contenu);?></td>
                    <td><?php echo $value->langue?></td>
                    <td><?php echo $value->created_by?></td>
                    <td>
                        <?php 
                        

                      // if ($m) 
                                   // {?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm-<?=$i?>" data-original-title="Editer"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <?php
                                   // }
                                    ?>
<!-- sample modal content -->
<div class="modal fade bs-example-modal-sm-<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">modifier verso de l'article</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal p-t-20" name="formaddClient">
                                
                                <div class="row">
                                       <input type="text" id="numero<?=$i?>" value="<?php echo $value->id_verso?>"hidden>
                                      <div class="col-lg-7 col-md-5">
                                        <div class="row">
                                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Langue</label>
                                            <div class="form-group col-sm-9">

                                                <select id="langue<?=$i?>" value="<?php echo $value->langue?>" class="form-control">
                                                    <option value="francais">francais</option>
                                                    <option value="anglais">anglais</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div></div>
                          
                                <div class="row">
                                   <div class="col-sm-12 col-md-12 col-lg-12 col-xlg-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="mdi mdi-comment-text"></i></span></div>
                                                <textarea type="text" rows="5" cols="2" class="form-control" id="corp_article<?=$i?>">
                                                    <?php echo iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value->contenu)?> 
                                                </textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button style="background-color: #8b4513"class="btn text-white waves-effect text-left" onclick="updateVeso($('#numero<?=$i?>').val(),$('#langue<?=$i?>').val(),$('#corp_article<?=$i?>').val())" data-dismiss="modal"><i class="fa fa-pencil"></i>modifier article
                            </button>
                            <button type="button" class="btn btn-dark waves-effect text-left" data-dismiss="modal"><i class="mdi mdi-close-circle-outline"></i>Fermer</button>
                        </div>
                    </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
            <!-- /.modal -->

            <?php
           // if ($s) 
          //  {?>
                <a href="javascript:void(0)" data-toggle="modal" data-target=".bs-example-modal-sm<?=$i?>" data-original-title="supprimer"> <i class="fa fa-trash text-inverse m-r-10"></i></a>
            <?php
          //  }
            ?>
            
                <!-- sample modal content -->
                <div class="modal fade bs-example-modal-sm<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Supprimer cet article</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body"> 
                            <input type="text" class="form-control" id="numero<?=$i?>" value="<?php echo $value->id_verso?>" hidden>
                            Voulez-vous supprimer cet article?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn waves-effect waves-light btn-rounded btn-danger" onclick="deleteVerso($('#numero<?=$i?>').val())" data-dismiss="modal"><i class="mdi mdi-delete-forever"></i></button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
        </td>
                </tr>
            <?php } ?>