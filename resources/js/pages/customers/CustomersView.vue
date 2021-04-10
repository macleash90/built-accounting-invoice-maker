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
      <form class="form" method="POST" @submit.prevent="updateCustomer" v-else>
        <customers-form 
        :form="form" :add_or_edit="add_or_edit">
        </customers-form>
        <div class="">
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
import CustomersForm from "./../customers/forms/CustomersForm";

export default {
  components: { BeatLoaderComponent, CustomersForm },
  props: ["id"],
  mounted() {
    this.getEditCustomerJson();
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
      add_or_edit: "view",
    };
  },
  methods: {
    getEditCustomerJson() {
      this.$Progress.start();
      this.isLoading = true;
      axios
        .get("/customers/json/" + this.id)
        .then((response) => {
          this.form.fill(response.data.customer);
          this.isLoading = false;
          this.$Progress.finish();
        })
        .catch((error) => {
          this.isLoading = false;
          this.$Progress.fail();
        });
    },
    updateCustomer() {
    },
  },
};
</script>