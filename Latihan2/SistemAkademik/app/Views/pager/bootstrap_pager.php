<?php $pager->setSurroundCount(2); ?>
<nav aria-label="Navigasi halaman">
    <ul class="pagination pagination-sm mb-0 justify-content-end">
        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

