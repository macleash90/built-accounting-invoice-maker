<template>
  <!-- begin row  -->
  <div class="row">
    <div class="col-lg-12">
      <!-- begin loader -->
      <beat-loader-component
        v-if="isLoading"
        :isLoading="isLoading"
      ></beat-loader-component>
      <!-- end loader -->
      <!--begin::Form-->
      <form class="form" method="POST" @submit.prevent="updateProduct" v-else>
        <items-form 
        :form="form" :add_or_edit="add_or_edit" :categories="categories" ref="childComponent" @fileUploaded="fileUploaded" 
        @processingImage="processingImage" @uploadError="uploadError">
        </items-form>
        <div class="">
          <div class="row">
            <div class="col-lg-6">
              <button
                type="submit"
                :disabled="isSaving"
                class="btn btn-primary mr-2"
              >
                Update
              </button>
            </div>
            <div class="col-lg-6 text-right"></div>
          </div>
        </div>
      </form>
      <!--end::Form-->
    </div>
  </div>
  <!-- end row  -->
</template>

<script>
import BeatLoaderComponent from "./../../components/Loader/BeatLoaderComponent";

import { Form, HasError, AlertError } from "vform";
import ItemsForm from "./../items/forms/ItemsForm";

export default {
  components: { BeatLoaderComponent, ItemsForm },
  props: ["id"],
  mounted() {
    this.getEditItemJson();
  },
  data() {
    return {
      // Create a new form instance
      form: new Form({
        name: "",
        item_price:"",
        item_description:"",
        img:"",
        item_img:"" 
      }),
      isLoading: false,
      categories: [],
      isSaving: false,
      add_or_edit: "edit",
    };
  },
  methods: {
    getEditItemJson() {
      this.$Progress.start();
      this.isLoading = true;
      axios
        .get("/items/json/" + this.id)
        .then((response) => {
          this.form.fill(response.data.item);
          this.isLoading = false;
          this.$Progress.finish();
        })
        .catch((error) => {
          this.isLoading = false;
          this.$Progress.fail();
        });
    },
    updateProduct() {
      this.isSaving = true;
      this.$Progress.start();
      this.form
        .put("/items/" + this.id)
        .then((response) => {
          this.isLoadingSaving = false;
          this.$Progress.finish();

          toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.isSaving = false;
          setTimeout(() => {
            window.location.href = response.data.url;
          }, 2000);
        })
        .catch((error) => {
          this.isSaving = false;
          this.$Progress.fail();
        });
    },
    fileUploaded(file_name)
    {
      this.form.img = file_name;
      this.isSaving = false;
    },
    processingImage()
    {
      this.isSaving = true;
    },
    uploadError()
    {
      this.isSaving = false;
    }
  },
};
</script>