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
      <form class="form" method="POST" @submit.prevent="storeCustomer" v-else>
        <customers-form
          :form="form"
          :add_or_edit="add_or_edit"
        ></customers-form>
        <div class="">
          <div class="row ml-2">
            <div class="col-lg-6 ">
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
import CustomersForm from "./forms/CustomersForm";

export default {
  components: { BeatLoaderComponent, CustomersForm },
  mounted() {
    this.getItemsOptionsJson();
  },
  data() {
    return {
      // Create a new form instance
      form: new Form({
        name: "",
        phone:"",
        email:"",
        address:"" 
      }),
      isLoading: false,
      isSaving: false,
      add_or_edit: "add",
    };
  },
  methods: {
    getItemsOptionsJson() {
    },
    storeCustomer() {
      this.isSaving = true;
      this.$Progress.start();
      this.form
        .post("/customers")
        .then((response) => {
          this.isLoadingSaving = false;
          this.$Progress.finish();
          this.$emit("customerCreated",response.data.customer);

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
  },
};
</script>


