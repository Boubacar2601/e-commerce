<?php 
require_once('inc/init.inc.php');


// si l'indice 'id_produit' est definit dans l'url ($_GET)et que sa valeur differente de vide, alors on entre dans le IF et on selectionne el'article en BDD
    if(isset($_GET['id_produit']) && !empty($_GET['id_produit']))
    {
        $productPdoS= $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
        $productPdoS->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_INT);
        $productPdoS->execute();  

        if($productPdoS->rowCount() >0)
        {
            $product=$productPdoS->fetch(PDO::FETCH_ASSOC);
            // echo '<pre>'; print_r($product); echo'</pre>)';


        }
        else
            
        {
            header('location: boutique.php');

        }

    }
    else
    {// sinon, si l'indice 'id_produit' n'est pas deninit dans l'url ou sa valeur est vide, alors on redirige l'internaute vers la page boutique.php 
        header('location: boutique.php');

    }



require_once('inc/inc_front/header.inc.php');
require_once('inc/inc_front/nav.inc.php');
?>

    <h1 class="text-center my-5">Détails de l'article</h1>

    <div class="row mb-5">
        <div class="bg-white shadow-sm rounded d-flex zone-card-fiche-produit">

            <a href="assets/img/tee-shirt1.jpg" data-lightbox="tee-shirt1" data-title="tee-shirt1" data-alt="tee-shirt1" class=""><img src="<?=$product['photo'] ?>" class="img-produit-fiche" alt="<?=$product['photo'] ?>"></a>

            <div class="col-12 col-sm-12 col-md-12 col-lg-9 card-body d-flex flex-column justify-content-center zone-card-body">
                <h5 class="card-title text-center fw-bold my-3"><?=$product['titre'] ?></h5>

                <p class="card-text"><?=$product['description'] ?></p>
                <p class="card-text fw-bold m-3">Taille : <?=strtoupper($product['taille']) ?></p>

                <div class="d-flex ">
                    <p class="fw-bold">
                         <span class="m-3">Couleur:</span> 
                         <div class="col-1 fp-couleur" style="background-color:<?=$product['couleur']?>"></div>
                     </p>
                </div>
                <p class="fw-bold d-flex flex-row aligne-items-center m-3"><?=strtoupper($product['prix']) ?>€</p>

                <?php if($product['stock'] <10 && $product['stock'] !=0): ?>

                <p class="card-text fst-italic text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> Attention ! il ne rest que <?=$product['stock']?> exemplaire(s) en stock. </p>

                <?php elseif($product['stock'] >10): ?>
                    <p class="card-text fst-italic text-success fw-bold"><i class="bi bi-check-square-fill"></i>  En stock !</p>

                <?php endif; ?>

                <p class="card-text">
                <?php if($product['stock'] > 0): ?>


                    <form action="panier.php" class="row g-3">
                        <div class="col-12 col-sm-7 col-md-4 col-lg-3 col-xl-3">
                            <label class="visually-hidden" for="autoSizingSelect">Quantité</label>
                            <select class="form-select " id="autoSizingSelect">
                                <option selected>Choisir une quantité...</option>

                                <?php for($q = 1; $q <= $product['stock'] && $q <= 30; $q++): ?>



                                <option value="<? $q ?>"><?=$q ?></option>
                                

                                <?php endfor; ?>

                            </select>
                        </div>
                        <div class="col-sm">
                            <input type="submit" class="btn btn-dark" value="Ajouter au panier">
                        </div>
                    </form>

                    <?php else: ?>
                        <span class="fst-italic fw-bold text-danger"><i class="bi bi-exclamation-diamond-fill"></i> </i>Rupture de stock!</span>

                    <?php endif; ?>

                </p>
            </div>
        </div>
        <p class="mt-1"><a href="boutique.php?cat=<?= $product['categorie']?>" class="text-dark alert-link"><i class="bi bi-arrow-left-circle-fill"></i> Retour à la catégorie <?= $product['categorie']?> </a></p>

        <p class="mt-1"><a href="boutique.php" class="text-dark alert-link"><i class="bi bi-arrow-left-circle-fill"></i> Retour à la boutique </a></p>

    </div>

<?php 
require_once('inc/inc_front/footer.inc.php'); 