<?php
    /** @var string  $redirect_link*/
    /** @var array  $accounts*/
?>

<div class="row">
    <div id="w0" class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <a class="btn btn-info" href="<?=$redirect_link?>" target="_blank">Telegram connect</a>
                    </div>
                    <div class="col-sm-12 col-md-6"></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12 col-md-6"></div>
                            <div class="col-sm-12 col-md-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped table-hover dataTable">
                                    <thead>
                                        <tr class="sort">
                                        <th>#</th>
                                        <th class="sorting">
                                           Chat ID
                                        </th>
                                        <th class="sorting">
                                            action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($accounts as $k => $account):?>
                                            <tr data-key="2">
                                                <td><?=$k+1?></td>
                                                <td><?=$account->chat_id?></td>
                                                <td>
                                                    <a class="btn btn-icon btn-danger" href="/profile/delete-chatid?id=<?=$account->chat_id?>">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
