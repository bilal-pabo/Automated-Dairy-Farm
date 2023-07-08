<main>
    <h1>Animal Profile</h1>
    <form id="profileForm">

        <div class="headinside">General Information</div>
        <div></div>
        
        <div class="formitem">
            <label for="id">Animal ID :</label>
            <input type="text" name="id" value="<?= $animalInfo->id ?>" id="id" class="id" placeholder="Enter animal id" required readonly>
        </div>

        <div class="formitem">
            <label for="breed">Breed :</label>
            <select name="breed" id="breed" required disabled>
            <option value="">Select breed</option>
                <?php 
                    for ($i = 0; $i < sizeof($breeds); $i++)
                    {
                       ?> <option value="<?= $breeds[$i] ?>" <?php if ($breeds[$i] == $animalInfo->breed) echo 'selected' ?> ><?php echo $breeds[$i] ?></option> <?php
                    }
                ?>
            </select>
        </div>

        <div class="formitem">
            <label for="gender">Gender :</label>
            <select name="gender" id="gender" required disabled>
                <option value="">Select animal type</option>
                 <option value="Cow" <?php if ($animalInfo->gender == 'Cow') echo 'selected' ?> >Cow</option>
                 <option value="Bull" <?php if ($animalInfo->gender == 'Bull') echo 'selected' ?> >Bull</option>
            </select>
        </div>

        <div class="formitem">
            <label for="color">Color :</label>
            <input type="text" name="color" value="<?php if($animalInfo->color) echo $animalInfo->color; else echo null; ?>" id="color" class="color" placeholder="N/A" readonly>
        </div>

        <div class="formitem">
            <label for="dob">Date of Birth :</label>
            <input type="date" name="dob" value="<?php if ($animalInfo->dob == date('0001-01-01')) echo null; else echo $animalInfo->dob; ?>" id="dob" class="dob" placeholder="Select date of birth" readonly>
        </div>

        <div class="formitem">
            <label for="price">Price :</label>
            <input type="number" name="price" value="<?php if ($animalInfo->price == -1) echo null; else echo $animalInfo->price; ?>" id="price" class="price" placeholder="N/A" readonly>
        </div>

<!-- 2nd part -->
    <?php 
        if ($animalInfo->gender == 'Cow')
        { ?> 
<div class="headinside">Insemination Details</div>
<div></div>
                <div class="formitem">
                    <label for="insemination">Type :</label>
                    <select name="insemination" id="insemination" disabled>
                        <option value="">Select insemination type</option>
                        <option value="Natural Insemination" <?php if ($animalInfo->insemination == 'Natural Insemination') echo 'selected' ?> >Natural Insemination</option>
                        <option value="Artificial Insemination" <?php if ($animalInfo->insemination == 'Artificial Insemination') echo 'selected' ?> >Artificial Insemination</option>
                    </select>
                </div>
                <div class="formitem">
                    <label for="bid">Bull ID :</label>
                    <input type="text" name="bid" value="<?= $animalInfo->bullid ?>" id="bid" class="bid" placeholder="N/A" readonly>
                </div>
                <div class="formitem">
                    <label for="date">Date :</label>
                    <input type="date" name="date" value="<?php if ($animalInfo->insdate == date('0001-01-01')) echo null; else echo $animalInfo->insdate; ?>" id="date" class="date" readonly>
                </div> 
                 <div></div>
                  <!-- 3rd part -->
                  <div class="headinside">Pregnancy Details</div>
                  <div></div>
                    
                <div class="formitem">
                    <label for="startDate">From :</label>
                    <input type="date" name="startDate" value="<?php if ($animalInfo->startdate == date('0001-01-01')) echo null; else echo $animalInfo->startdate; ?>" id="startDate" class="startDate" readonly>
                </div> 

                <div class="formitem">
                    <label for="deliveryDate">Delivery :</label>
                    <input type="date" name="deliveryDate" value="<?php if ($animalInfo->deliverydate == date('0001-01-01')) echo null; else echo $animalInfo->deliverydate; ?>" id="deliveryDate" class="deliveryDate" readonly>
                </div> 

                <div class="formitem">
                    <label for="abortionDate">Abortion :</label>
                    <input type="date" name="abortionDate" value="<?php if ($animalInfo->abortiondate == date('0001-01-01')) echo null; else echo $animalInfo->abortiondate; ?>" id="abortionDate" class="abortionDate" readonly>
                </div> 
            
            </form>
  <?php }
    ?>
</main>