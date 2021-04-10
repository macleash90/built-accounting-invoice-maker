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
      <form class="form" method="POST" @submit.prevent="storeItem" v-else>
        <items-form
          :form="form"
          :add_or_edit="add_or_edit"
          @fileUploaded="fileUploaded"
          ref="childComponent"
          @processingImage="processingImage"
          @uploadError="uploadError"
        ></items-form>
        <div class="">
          <div class="row">
            <div class="col-lg-6">
              <button
                type="submit"
                :disabled="isSaving"
                class="btn btn-primary mr-2"
              >
                Save
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
import ItemsForm from "./forms/ItemsForm";

export default {
  components: { BeatLoaderComponent, ItemsForm },
  mounted() {
    this.getItemsOptionsJson();
  },
  data() {
    return {
      // Create a new form instance
      form: new Form({
        name: "",
        item_price:"",
        item_description:"",
        img:"",
        item_img:"" //this var is for items already saved ie edit/view page
      }),
      isLoading: false,
      isSaving: false,
      add_or_edit: "add",
    };
  },
  methods: {
    getItemsOptionsJson() {
    },
    storeItem() {
      this.isSaving = true;
      this.$Progress.start();
      this.form
        .post("/items")
        .then((response) => {
          this.isLoadingSaving = false;
          this.$Progress.finish();
          this.$emit("itemCreated",response.data.item);

          this.$refs.childComponent.resetImage();

          toast.fire({
            icon: "success",
            title: response.data.message,
          });
          this.isSaving = false;
          this.form.reset();
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