<?php $__env->startSection('main'); ?>

    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>List Store</h2>

                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <table class="table table-bordered">
                            <thead>
                            <tr>

                                <th>Name</th>
                                <th>Image</th>
                                <th>Department</th>
                                <th>User Email</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = \App\Store::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>

                                    <td><?php echo e($item->name); ?></td>
                                    <td><img width="100px" src="<?php echo e(url('public/image/' . $item->img)); ?>"></td>
                                    <td><?php echo e(\App\Category::findOrFail($item->category_id)->name); ?></td>
                                    <td><?php echo e($item->user_id != 0 ? \App\User::findOrFail($item->user_id)->email : 'Admin'); ?></td>
                                    <td><a href="<?php echo e(url('admin/user/delete/' . $item->id)); ?>">Delete</a></td>

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