<template>
    <div class="container">
        <h1>Nouveau produit</h1>

        <form @submit.prevent="checkForm" method="post">

            <!-- Is Service -->
            <div class="form-check mb-3">
                <div class="col-auto">
                    <input v-model="formData.isService" class="form-check-input" type="radio" name="isService" value="0" id="isService">
                    <label class="form-check-label" for="isService">
                        Produit
                    </label>
                </div>
                <div class="col-auto">
                    <input v-model="formData.isService" class="form-check-input" type="radio" name="isService"  value="1" id="isService" checked>
                    <label class="form-check-label" for="isService">
                        Service
                    </label>
                </div>
            </div>

            <template v-if="formData.isService !== null">

                <hr class="my-3">

                <!-- 
                    CATEGORY
                -->
                <div class="mb-3">
                    <label for="category" class="form-label">Catégorie / Famille <small class="grape-2">obligatoire</small></label>
                    <select id="category" name="category" required v-model="formData.category" class="form-select" aria-label="Sélection d'une Catégorie / Famille">
                        <option selected>Choisir une catégorie</option>
                        <option v-for="(category, id) in listCategory" :key="id" :value="category['@id']">{{ category.name }}</option>
                        
                    </select>
                </div>
                
                <!-- 
                    NAME
                -->
                <div class="mb-3">
                    <label for="category" class="form-label">Nom <small class="grape-2">obligatoire</small></label>
                    <input name="name" required v-model="formData.name" type="text" class="form-control">
                </div>


                <!-- 
                    PRICE
                -->
                <div class="row">
                    <div class="col-auto p-4">
                        <span class="lg-3"><i class="far fa-fw fa-2x fa-euro-sign"></i></span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="mb-3">
                            <label for="price" class="form-label">Prix <small class="sunflo-2">optionnel</small></label>
                            <input id="price" name="price" v-model.number="formData.price" type="number" class="form-control">
                            <div id="priceHelp" class="form-text">En euros</div>
                        </div>
                    </div>
                </div>


                <!-- DURATION / BATTEMENT -->
                <div class="row" v-if="formData.isService == 1">
                    <div class="col-auto p-4">
                        <span class="lg-3"><i class="far fa-fw fa-2x fa-stopwatch"></i></span>
                    </div>
                    <div class="col">
                        <div class="row">
                            <!-- Duration -->
                            <div class="col-6">
                                <label for="duration" class="form-label">Durée <small class="sunflo-2">optionnel</small></label>
                                <input id="duration" name="duration" v-model.number="formData.duration" type="number" class="form-control">
                                <div id="durationHelp" class="form-text">En minutes</div>
                            </div>
                            <!-- Tunraround Time -->
                            <div class="col-6">
                                <label for="turnaround-time" class="form-label">Battement <small class="sunflo-2">optionnel</small></label>
                                <input id="turnaround-time" name="turnaround-time" v-model.number="formData.turnaroundTime" type="number" class="form-control">
                                <div id="turnaroundHelp" class="form-text">En minutes</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 
                    TEA 
                -->
                <!-- <div class="row mb-3" v-if="formData.isService == 1">
                    <div class="col-auto p-4">
                        <span class="lg-3"><i class="far fa-fw fa-2x fa-mug-tea"></i></span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <div class="form-check">
                            <label for="tea" class="form-check-label">Tisane <small class="sunflo-2">optionnel</small></label>
                            <input id="tea" name="tea" v-model.number="formData.tea" type="checkbox" class="form-check-input">
                            <div id="teaHelp" class="form-text mt-0">Tisane offerte à la fin de la prestation ?</div>
                        </div>
                    </div>
                </div> -->


                <hr class="my-3">

                <!-- PICTURES JPEG / WEBP -->
                <div class="row">
                    <div class="col-auto p-4">
                        <span class="lg-3"><i class="fa-regular fa-images fa-fw fa-2x"></i></span>
                    </div>
                    <div class="col">
                        <div class="row">
                            <!-- Image en Webp -->
                            <div class="col-12 col-lg-6 py-2">
                                <label for="image-webp" class="form-label">Image WEBP <small class="sunflo-2">optionnel</small></label>
                                <input id="image-webp" name="image-webp" type="file" class="form-control" @change="processWebp($event)">
                            </div>
                            <!-- Image en Jpeg -->
                            <div class="col-12 col-lg-6 py-2">
                                <label for="image-jpeg" class="form-label">Image JPG <small class="sunflo-2">optionnel</small></label>
                                <input id="image-jpeg" name="image-jpeg" type="file" class="form-control" @change="processJpeg($event)">
                            </div>
                        </div>
                    </div>
                </div>


                <hr class="my-3">


                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description courte <small class="sunflo-2">optionnel</small></label>
                    <textarea id="description" name="description" v-model="formData.shortDescription" class="form-control" rows="5"></textarea>
                </div>

                <!-- Warning Text -->
                <div class="mb-3">
                    <label for="warning-text" class="form-label">Avertissement / Condition <small class="sunflo-2">optionnel</small></label>
                    <textarea id="warning-text" name="warning-text" v-model="formData.warningText" class="form-control" rows="2"></textarea>
                </div>

                <hr class="my-3">

                <div class="row">
                    <!-- Dispo Web -->
                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <label for="dispo-web" class="form-check-label">Dispo Web <small class="sunflo-2">optionnel</small></label>
                            <input id="dispo-web" name="dispo-web" v-model.number="formData.isAvailableOnSite" type="checkbox" class="form-check-input">
                            <div id="dispoWebHelp" class="form-text mt-0">Disponible sur le site internet</div>
                        </div>
                    </div>
                    <!-- Dispo Institut -->
                    <!-- <div class="col-12 mb-3">
                        <div class="form-check">
                            <label for="dispo-institut" class="form-check-label">Dispo Institut <small class="sunflo-2">optionnel</small></label>
                            <input id="dispo-institut" name="dispo-institut" v-model.number="formData.isAvailableForAppointment" type="checkbox" class="form-check-input">
                            <div id="dispoInstitutHelp" class="form-text mt-0">Disponible sur l'application de l'Institut</div>
                        </div>
                    </div> -->
                    <!-- Dispo Appointment -->
                    <div class="col-12" v-if="formData.isService == 1">
                        <div class="form-check">
                            <label for="dispo-appointment" class="form-check-label">Dispo Rdv <small class="sunflo-2">optionnel</small></label>
                            <input id="dispo-appointment" name="dispo-appointment" v-model.number="formData.isAvailableForAppointment" type="checkbox" class="form-check-input">
                            <div id="dispoAppointmentHelp" class="form-text mt-0">Disponible à la prise de rendez-vous</div>
                        </div>
                    </div>
                </div>

                

                <div v-if="formData.isService == 1">
                    <p>Habilitations</p>
                    <hr class="my-3">
                </div>

                

                <div v-if="formData.isService == 1">
                    <p>Ressources Cabines</p>
                    <hr class="my-3">
                </div>

                

                <button type="submit" class="btn btn-success">Valider</button>
            </template>

        </form>
    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        data(){
            return {
                listCategory: [],
                formData: {
                    name: null,
                    price: null,
                    category: null,
                    jpgPicture: null,
                    webpPicture: null,
                    shortDescription: null,
                    isService: null,
                    duration: null,
                    turnaroundTime: null,
                    fullDescription: null,
                    warningText: null,
                    isAvailableOnSite: null,
                    isAvailableForAppointment: null,
                },
                errors: [],   
            }
        },
        methods:{

            checkForm() {

                this.errors = [];

                if (!this.formData.name) {
                    this.errors.push('Le nom n\'est pas renseigné');
                }
                if (!this.formData.category) {
                    this.errors.push('La catégorie n\'est pas renseigné');
                }

                console.log(this.formData.category);

                console.log(this.formData);

                axios.post('https://127.0.0.1:8000/api/products', {
                    name: this.formData.name,
                    price: this.formData.price,
                    category: this.formData.category,
                    jpgPicture: null,
                    webpPicture: null,
                    shortDescription: this.formData.shortDescription,
                    isService: this.formData.isService == 1 ? true : false,
                    duration: this.formData.duration,
                    turnaroundTime: this.formData.turnaroundTime,
                    fullDescription: null,
                    warningText: this.formData.warningText,
                    isAvailableOnSite: true,
                    isAvailableForAppointment: true,
                });

                // axios.post('https://127.0.0.1:8000/api/media_objects'), {
                //     file: this.formData.jpgPicture
                // }
                  
                this.resetForm();

            },
            resetForm(){
                this.formData = {
                    name: null,
                    price: null,
                    category: null,
                    jpgPicture: null,
                    webpPicture: null,
                    shortDescription: null,
                    isService: null,
                    duration: null,
                    turnaroundTime: null,
                    fullDescription: null,
                    warningText: null,
                    isAvailableOnSite: null,
                    isAvailableForAppointment: null,
                }
            },
            processWebp(event) {
                this.formData.webpPicture = event.target.files[0]
                console.log(this.formData.webpPicture)
            },
            processJpeg(event) {
                this.formData.jpgPicture = event.target.files[0]
                console.log(this.formData.jpgPicture)
            }
        },
        created(){
            axios.get('https://127.0.0.1:8000/api/categories')
                .then(response => {
                    console.log(response);
                    this.listCategory = response.data['hydra:member']
                })
        }
    };

</script>

<style>
</style>