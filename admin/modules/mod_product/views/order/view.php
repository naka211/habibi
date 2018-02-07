<div class="row">
    <div class="col-sm-12">
        <div id="detail-toolbar"></div>
        <table id="detail_list_table"
            data-toggle="table"
            data-url="<?php echo site_url($this->module_name.'/order/getContentDetail/'.$id);?>"
            data-toolbar="#detail-toolbar"
            data-side-pagination="server"
            data-pagination="true"
            data-show-refresh="true"
            data-show-toggle="true"
            data-show-columns="true"
            data-show-export="true"
            data-page-list="[5,10,20,50,100,200,ALL]"
            data-mobile-responsive="true">
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="id">ID</th>
                    <th data-field="codes">Code</th>
                    <th data-field="product_name">Product</th>
                    <th data-field="quantity">Quantity</th>
                    <th data-field="subtotal">Price</th>
                    <th data-field="used">Used</th>
                    <th data-field="bl_active">Check</th>
                    <th data-field="dt_create">Date</th>
                    <th class="text-center action" data-field="action"><?php echo lang('admin.functions');?></th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("#detail_list_table").bootstrapTable();
    })
</script>