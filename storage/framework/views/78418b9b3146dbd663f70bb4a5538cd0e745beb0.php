<?php $__env->startSection('main'); ?>

    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>List Coupon</h2>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <table class="table table-bordered">
                            <thead>
                            <tr>

                                <th>Id</th>
                                <th>Link</th>
                                <th>Store</th>
                                <th>Type</th>

                                <th>Code</th>
                                <th>Description</th>
                                <th>Expiration Date</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = \App\Coupon::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>

                                    <td><?php echo e($item->id); ?></td>
                                    <td><?php echo e($item->link); ?></td>

                                    <td><?php echo e(\App\Store::findOrFail($item->store_id )->name); ?></td>
                                    <td><?php echo e($item->type); ?></td>

                                    <td><?php echo e($item->code); ?></td>
                                    <td><?php echo e($item->description); ?></td>
                                    <td><?php echo e($item->exp_date); ?></td>
                                    <td><a href="<?php echo e(url('admin/coupon/delete/' . $item->id)); ?>">Delete</a></td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>