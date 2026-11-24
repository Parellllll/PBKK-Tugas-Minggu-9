<?php $pager->setSurroundCount(2); ?>
<nav aria-label="Navigasi halaman">
    <ul class="pagination pagination-sm mb-0 justify-content-end">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item"><a class="page-link" href="<?= $pager->getPrevious() ?>">&lsaquo;</a></li>
        <?php endif; ?>
        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach; ?>
        <?php if ($pager->hasNext()) : ?>
            <li class="page-item"><a class="page-link" href="<?= $pager->getNext() ?>">&rsaquo;</a></li>
        <?php endif; ?>
    </ul>
</nav>

