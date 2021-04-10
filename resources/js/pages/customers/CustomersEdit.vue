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
import CustomersForm from "./../customers/forms/CustomersForm";

export default {
  components: { BeatLoaderComponent, CustomersForm },
  props: ["id"],
  mounted() {
    this.getEditCustomersJson();
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
      add_or_edit: "edit",
    };
  },
  methods: {
    getEditCustomersJson() {
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
      this.isSaving = true;
      this.$Progress.start();
      this.form
        .put("/customers/" + this.id)
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
  },
};
</script>

