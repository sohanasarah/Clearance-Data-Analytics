<?php if($paginator->hasPages()): ?>
    <ul class="pagination">
        
        <?php if($paginator->onFirstPage()): ?>
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
<?php else: ?>
            <li class="page-item"><a href="<?php echo e($paginator->previousPageUrl()); ?>" class="page-link" rel="prev">&laquo;</a></li>
<?php endif; ?>


<?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <?php if(is_string($element)): ?>
            <li class="page-item disabled"><?php echo e($element); ?></li>
    <?php endif; ?>

    
    <?php if(is_array($element)): ?>
        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $paginator->currentPage()): ?>
                        <li class="page-item active">
                            <a href="#" class="page-link"><?php echo e($page); ?><span class="sr-only">(current)</span></a>
                        </li>
                <?php else: ?>
                        <li class="page-item">
                            <a href="<?php echo e($url); ?>" class="page-link"><?php echo e($page); ?></a>
                        </li>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
                <li class="page-item"><a href="<?php echo e($paginator->nextPageUrl()); ?>" class="page-link" rel="next">&raquo;</a></li>
        <?php else: ?>
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
        <?php endif; ?>
    </ul>
    <?php endif; ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/inc/pagination.blade.php ENDPATH**/ ?>