<?php include 'Layout.php'; ?>
<?=template_header('Home')?>


<div class="container pt-5 pb-4 text-center ">
	<!-- descrierea scurta a magazinului -->
	<div class="Desprenoi">
		<div class="pt-2 pb-1 pl-2 pr-2" style="background-color: white;border-top-left-radius:10px ;border-top-right-radius: 10px">
			<b><p class="text-danger" style="font-size: 30px;">Despre noi<p></b>
		</div>
		<div class="pt-4 pb-4 pl-4 pr-4">
			<p><b>The Dice Knighthood</b> este magazinul de jocuri de societate care transforma joaca intr-o stiinta. Obiectivul nostru principal este de a stimula interactiunea umana prin activitati si jocuri amuzante, interesante si originale.</p>
			<br/>
			<p>Punem la dispozitia ta jocuri de societate distractive; jocuri de strategie care te vor captiva; jocuri de perspicacitate care iti vor pune mintea la contributie; jocuri de petrecere (drinking games) pentru acele momente in care vrei sa te distrezi cu prietenii tai si multe altele.</p>
			</br>
			<p>Vom lucra incontinuu pentru a gasi noi metode si produse care vor aduce joaca in viata ta pentru ca, asa cum zicea George Bernard Shaw: “Nu ne oprim din joaca atunci cand imbatranim; imbatranim atunci cand ne oprim din joaca.”.</p>
		</div>
	</div>

    <!-- categoriile de jocuri -->
	<div class="pt-4 pb-4 mt-5 jocuri-categorii">
		<div class="row">
			<div class="col-md-6">
				<a href="Produse.php?categorie=1">
			       <img src="Jocuri de societate de petrecere5754.png" height="400px">
			    </a>
			</div>
			<div class="col-md-6">
			  	<a href="Produse.php?categorie=2">
			       <img src="Jocuri de societate de mister1385.png" height="400px">
			    </a>
			</div>
	    </div>

		<div class="row">
			<div class="col-md-6">
				<a href="Produse.php?categorie=3">
					<img src="Jocuri de familie5609.png" height="400px">
				</a>
			</div>
			<div class="col-md-6">
				<a href="Produse.php?categorie=4">
					<img src="Jocuri de strategie4577.png" height="400px">
				</a>
			</div>
		</div>

	<a href="Produse.php"><button class="btn btn-danger mt-5" style="width:200px;">Vezi toate jocurile!</button></a>
	</div>

</div>


<?=template_footer()?>
  