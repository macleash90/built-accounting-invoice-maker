<template>
  <div
    class="modal fade"
    id="itemsCreateModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="itemsCreateModal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmSaleModalTitle">Create Item</h5>
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
          <items-create @itemCreated="itemCreated"></items-create>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ItemsCreate from "./../../../pages/items/ItemsCreate";
export default {
  components: {
    ItemsCreate,
  },
  methods: {
    itemCreated(item) {
      $("#itemsCreateModal").modal("hide");
      this.$emit("itemSaved", item);
    },
  },
};
</script>