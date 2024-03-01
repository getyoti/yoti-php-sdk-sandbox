<table>
    <tr>
        <td>Type</td>
        <td><?php echo e($documentDetails->getType()); ?></td>
    </tr>
    <tr>
        <td>Issuing Country</td>
        <td><?php echo e($documentDetails->getIssuingCountry()); ?></td>
    </tr>
    <tr>
        <td>Document Number</td>
        <td><?php echo e($documentDetails->getDocumentNumber()); ?></td>
    </tr>
    <tr>
        <td>Expiration Date</td>
        <td><?php echo e($documentDetails->getExpirationDate()->format('d-m-Y')); ?></td>
    </tr>
</table><?php /**PATH /usr/share/nginx/html/resources/views/partial/documentdetails.blade.php ENDPATH**/ ?>