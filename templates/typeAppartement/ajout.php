<h1 class="text-center">Ajout d'un type d'appartement</h1>
<form action="/typeappart/ajoutTrait" method='post'>
    <div class="row mb-3">
        <label for="libelle" class="col-lg-4 col-form-label">Libelle</label>
        <div class="col-sm-12">
            <input type="text" class="form-control" name="libelle" value="<?php if (isset($lesTypesAppart))  echo $lesTypesAppart->getLesTypes();  ?>" id="libelle">
        </div>
    </div>
    
    <div class="p-3 mb-4">
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </div>
</form>
<?php
if (isset($msg)) echo $msg;
?>