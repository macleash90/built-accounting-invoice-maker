<template>
  <div
    class="modal fade"
    id="customersCreateModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="customersCreateModal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmSaleModalTitle">
            Create Customer
          </h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">
          <customers-create @customerCreated="customerCreated"></customers-create>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import CustomersCreate from "./../../../pages/customers/CustomersCreate";
export default {
  components: {
    CustomersCreate,
  },
  methods: {
    customerCreated(customer) {
      $("#customersCreateModal").modal("hide");
      this.$emit("customerSaved", customer);
    },
  },
};
</script>