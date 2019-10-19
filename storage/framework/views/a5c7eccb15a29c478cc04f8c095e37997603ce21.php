<table class="table table-striped table-inverse table-bordered">
    <?php if(count($posts)): ?>
        <thead class="thead-inverse">
        <tr>
            <th>Group Name</th>
            <th>Group Type</th>
            <th>Account Name</th>
            <th>Post Text</th>
            <th>Time</th>
        </tr>
        </thead>
        <tbody >
        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($post->groupInfo->name); ?></td>
                <td><?php echo e($post->groupInfo->type); ?></td>
                <td><?php echo e($post->groupInfo->user->name); ?></td>
                <td><?php echo e($post->post_text); ?></td>
                <td><?php echo e($post->created_at); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    <?php else: ?>
        <tr><td colspan="3">No Data Found</td></tr>
    <?php endif; ?>
</table>
<div class="paginate">
    <?php echo e($posts->links()); ?>

</div>