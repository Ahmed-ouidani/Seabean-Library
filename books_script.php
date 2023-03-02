<div class="col-lg-6">
    <div class="m-3 reco-items book-infos d-flex p-2 row d-flex align-items-center text-light col-md-5 col-lg-12">
        <div class="col-lg-3 d-flex mb-2 justify-content-center">
            <img src="uploadedimgs/<?php echo $result['img'];?>" alt="" class="img-fluid">
        </div>


        <div class="col-lg-4">
            <h5><?php echo $result['book_name'];?></h5>
            <p> De : <?php echo $result['auteur'];?>.</p>
        </div>
        <div class="col-lg-5">
            <div class="note">
                <i class="fa-solid fa-star"></i> <?php echo $result['note'];?>/5
            </div>
            <div class="dispo <?php echo $result['etat'];?>">
                <span>Etat</span>
                <i class="fa-solid fa-circle"></i> <?= ($result['etat'] == 'NoInfo') ? "Pas d'information" : $result['etat']?>
            </div>
            <div class="discre">
                <p>
                    &emsp; <?php echo $result["discription"];?>
                </p>
            </div>
            <div class="d-flex justify-content-end se-mr pe-4 mb-2">
                <a class="btn rounded-pill p-1 see-mr-btn" href="book-item.php?book_id=<?php echo $result['id'];?>"><span>Voir Plus</span></a>
            </div>
        </div>
    </div>
</div>