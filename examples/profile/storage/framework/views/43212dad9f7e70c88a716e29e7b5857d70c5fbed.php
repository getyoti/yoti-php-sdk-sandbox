<table>
    <tr>
        <td>Check Type</td>
        <td><?php echo e($ageVerification->getCheckType()); ?></td>
    </tr>
    <tr>
        <td>Age</td>
        <td><?php echo e($ageVerification->getAge()); ?></td>
    </tr>
    <tr>
        <td>Result</td>
        <td><?php echo e($ageVerification->getResult() ? 'true' : 'false'); ?></td>
    </tr>
</table><?php /**PATH /usr/share/nginx/html/resources/views/partial/ageverification.blade.php ENDPATH**/ ?>