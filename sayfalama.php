<?php
echo '<div class="row">
                                <div class="col-md-12">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center">';

$sayfa_goster = 11; // gösterilecek sayfa sayısı

$en_az_orta = ceil($sayfa_goster/2);
$en_fazla_orta = ($toplam_sayfa+1) - $en_az_orta;

$sayfa_orta = $sayfa;
if($sayfa_orta < $en_az_orta) $sayfa_orta = $en_az_orta;
if($sayfa_orta > $en_fazla_orta) $sayfa_orta = $en_fazla_orta;

$sol_sayfalar = round($sayfa_orta - (($sayfa_goster-1) / 2));
$sag_sayfalar = round((($sayfa_goster-1) / 2) + $sayfa_orta);

if($sol_sayfalar < 1) $sol_sayfalar = 1;
if($sag_sayfalar > $toplam_sayfa) $sag_sayfalar = $toplam_sayfa;

if($sayfa != 1)
{
    echo '
<li class="page-item">
    <a class="page-link" href="?sayfa=1" tabindex="-1">İlk Sayfa</a>
</li>
';
}

if($sayfa != 1)
{
    echo '
<li class="page-item"><a class="page-link" href="?sayfa='.($sayfa-1).'">Önceki</a></li>
';
}

for($s = $sol_sayfalar; $s <= $sag_sayfalar; $s++) {
    if($sayfa == $s) {
        echo '<li class="page-item disabled"><a class="page-link">'.$s.'</a></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="?sayfa='.$s.'">'.$s.'</a></li>';
    }
}

if($sayfa != $toplam_sayfa)
{
    echo '
<li class="page-item">
    <a class="page-link" href="?sayfa='.($sayfa+1).'" tabindex="-1">Sonraki</a>
</li>
';
}

if($sayfa != $toplam_sayfa)
{
    echo '
<li class="page-item">
    <a class="page-link" href="?sayfa='.$toplam_sayfa.'" tabindex="-1">Son Sayfa</a>
</li>
';
}

echo '</ul>
                                    </nav>
                                </div>
                            </div>';
?>