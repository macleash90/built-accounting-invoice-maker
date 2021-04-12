<template>
  <div class="d-flex">
    <div class="row pos-side">
      <div class="form-group col-md-5">
        <label class="d-flex justify-content-between">
          <div class="d-flex">Item:<star></star></div>
          <div class="">
            <button
              class="btn btn-sm btn-primary"
              @click.prevent="openItemCreateModal"
            >
              Add New
            </button>
          </div>
        </label>
        <div class="">
          <multiselect
            v-model="form.selected_item"
            placeholder="Search or select an Item"
            label="name"
            track-by="id"
            :options="items"
            :option-height="50"
            :custom-label="customLabel"
            :show-labels="false"
            @input="itemSelected"
          >
            <template slot="singleLabel" slot-scope="props"
              ><img
                height="80px"
                class="option__image mr-2"
                :src="props.option.item_img"
                alt="Item Image"
              /><span class="option__desc"
                ><span class="option__title">{{
                  props.option.name
                }}</span></span
              ></template
            >
            <template slot="option" slot-scope="props"
              ><img
                height="80px"
                class="option__image mr-2"
                :src="props.option.item_img"
                alt="Product Image"
              />
              <span class="option__desc"
                ><span class="option__title">{{
                  props.option.name
                }}</span></span
              >
            </template>
          </multiselect>
          <errors v-if="form.errors.errors.selected_item">
            {{ form.errors.errors.selected_item[0] }}
          </errors>
        </div>
      </div>
      <div class="form-group col-md-4">
        <label class="d-flex justify-content-between">
          <div class="d-flex">Customer:<star></star></div>
          <div class="">
            <button
              @click.prevent="openCustomersCreateModal"
              class="btn btn-sm btn-success"
            >
              Add New
            </button>
          </div>
        </label>
        <div class="">
          <multiselect
            v-model="form.selected_customer"
            :options="customers"
            name="selected_customer"
            placeholder="Search or select a customer"
            label="name"
            track-by="id"
          ></multiselect>
          <errors v-if="form.errors.errors.selected_customer">
            {{ form.errors.errors.selected_customer[0] }}
          </errors>
        </div>
      </div>
      <div class="form-group col-md-3">
        <label class="d-flex justify-content-between">
          <div class="d-flex">Date:<star></star></div>
          <div class="">
          </div>
        </label>
        <div class="">
          <input type="date" class="form-control" v-model="form.invoice_date" />
          <errors v-if="form.errors.errors.invoice_date">
            {{ form.errors.errors.invoice_date[0] }}
          </errors>
        </div>
      </div>

      <div class="form-group col-md-12">
        <div class="form-group">
          <div class="table-responsive">
            <table id="posTable" class="table table-hover table-striped">
              <thead>
                <tr class="row">
                  <th class="col-sm-2"><h4>Image</h4></th>
                  <th class="col-sm-3"><h4>Product</h4></th>
                  <th class="col-sm-2"><h4>Price (GHS)</h4></th>
                  <th class="col-sm-2"><h4>Quantity</h4></th>
                  <th class="col-sm-2"><h4>Subtotal (GHS)</h4></th>
                  <th class="col-sm-1"></th>
                </tr>
              </thead>
              <tbody>
                <tr
                  class="row"
                  v-for="(product_sale, index) in item_invoices"
                  :key="index"
                >
                  <td class="col-sm-2 product-price">
                    <img :src="product_sale.item_img" height="50px" />
                  </td>
                  <td class="col-sm-3 product-title">
                    <button type="button" class="edit-product btn btn-link">
                      <strong
                        ><p>
                          {{ product_sale.name }}
                        </p></strong
                      >
                    </button>
                  </td>
                  <td class="col-sm-2 product-price">
                    {{ product_sale.item_price }}
                  </td>
                  <td class="col-sm-2">
                    <div class="input-group">
                      <span class="input-group-btn">
                        <a
                          href="javascript:void(0)"
                          @click.prevent="subTractQty(index)"
                          class="btn btn-icon btn-light btn-hover-primary btn-sm"
                        >
                          <span class="svg-icon svg-icon-md svg-icon-primary">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                            <i class="fas fa-minus-circle text-danger mr-1"></i>
                            <!--end::Svg Icon-->
                          </span>
                        </a>
                      </span>
                      <input
                        type="text"
                        class="form-control qty-number"
                        v-model="product_sale.qty"
                        step="any"
                        required=""
                        aria-haspopup="true"
                        role="textbox"
                        @input="editQty(index, product_sale.qty)"
                      />
                      <a
                        href="javascript:void(0)"
                        @click.prevent="addQty(index)"
                        class="btn btn-icon btn-light btn-hover-primary btn-sm"
                      >
                        <span class="svg-icon svg-icon-md svg-icon-primary">
                          <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                          <i class="fas fa-plus-circle text-success ml-1"></i>
                          <!--end::Svg Icon-->
                        </span>
                      </a>
                    </div>
                  </td>
                  <td class="col-sm-2 sub-total">{{ subTotal(index) }}</td>
                  <td class="col-sm-1">
                    <span class="input-group-btn">
                      <a
                        href="javascript:void(0)"
                        class="btn btn-icon btn-light btn-hover-primary btn-sm"
                        @click="deleteProductSale(index)"
                      >
                        <span class="svg-icon svg-icon-md svg-icon-primary">
                          <!--begin::Svg Icon | path:assets/media/svg/icons/General/Settings-1.svg-->
                          <i class="far fa-window-close text-danger mr-1"></i>
                          <!--end::Svg Icon-->
                        </span>
                      </a>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="form-group col-md-12">
        <div
          class="col-12 totals"
          style="border-top: 2px solid #e4e6fc; padding-top: 10px"
        >
          <div class="row">
            <div class="col-sm-3 d-flex">
              <h3 class="totals-title mr-1">Items:</h3>
              <h3 id="item" class="red_color">{{ item_invoices.length }}</h3>
            </div>
            <div class="col-sm-3 d-flex">
              <h3 class="totals-title mr-1">Total Qty:</h3>
              <h3 id="item" class="red_color">{{ totalQty }}</h3>
            </div>
            <div class="col-sm-3 d-flex">
              <h3 class="totals-title mr-1">Total (GHS):</h3>
              <h3 class="red_color" id="subtotal">{{ total }}</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group col-md-12">
        <div class="payment-amount">
          <h2>
            Grand Total: GHS
            <span id="grand-total">{{ grandTotal ? grandTotal : total }}</span>
          </h2>
        </div>
      </div>
      <div class="form-group col-md-12 d-flex justify-content-center">
        <!-- <h3 class="mr-2">Pay With:</h3> -->
        <button
          type="button"
          class="btn btn-primary font-weight-bold font-size-h3 px-12 py-1 mr-4"
          @click.prevent="generateInvoice()"
          :disabled="can_generate_invoice"
        >
          <i class="fas fa-money-bill-alt"></i>Generate Invoice
        </button>
      </div>
    </div>
    <div v-if="false" class="product-list">
      <h2 class="m-4">Products List</h2>
      <div>
        <div
          @click.prevent="addProductToSale(product)"
          :key="product.id"
          v-for="product in items"
          class="card card-custom m-4 product-item"
        >
          <div class="d-flex flex-column align-items-center">
            <div class="p-2">
              <img height="70px" :src="imageUrl(product.item_img)" />
            </div>
            <div>
              <h6>{{ product.name }} - GHS {{ product.item_price }}</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- finalize payment Modal-->
    <finalize-payment-modal
      :finalize_modal_saving="finalize_modal_saving"
      :changeAmount="changeAmount"
      :form="form"
      :payment_options="payment_options"
      @finalize-sale-submit="finalizeSaleSubmit"
      @clear-payment-amount="clearPaymentAmount"
    ></finalize-payment-modal>
    <!-- End finalize Modal -->

    <!-- create customer Modal-->
    <customer-create-modal
      @customerSaved="customerSaved"
    ></customer-create-modal>
    <!-- End create customer Modal -->

    <!-- create customer Modal-->
    <item-create-modal @itemSaved="itemSaved"></item-create-modal>
    <!-- End create customer Modal -->
  </div>
</template>
<script>
import Multiselect from "vue-multiselect";
import { Form, HasError, AlertError } from "vform";
import FinalizePaymentModal from "./modals/FinalizePaymentModal";
import CustomerCreateModal from "./modals/CustomerCreateModal";
import ItemCreateModal from "./modals/ItemCreateModal";
export default {
  components: {
    Multiselect,
    FinalizePaymentModal,
    CustomerCreateModal,
    ItemCreateModal,
  },
  props: ["customer_title", "current_date"],
  data() {
    return {
      // Create a new form instance
      form: new Form({
        selected_customer: "",
        selected_item: "",
        momo_number: "",
        selected_payment_option: "",
        paid_amount: "",
        cash_payment: "",
        momo_payment: "",
        amount_to_pay: "",
        sale_note: "",
        change: 0.0,
        sale_date: this.current_date,
        item_invoices: [],
        bonus_bags_qty: 0,
        selected_item: "",
        grandTotal:"",
        total:"",
        invoice_date:"",
      }),
      isLoading: true,
      customers: [],
      isSaving: false,
      item_invoices: [],
      payment_options: ["Cash", "Momo", "Cash and Momo", "Credit"],
      finalize_modal_saving: false,
      items: [],
    };
  },
  mounted() {
    this.getInvoiceOptionsJson();
  },
  methods: {
    customLabel({ name }) {
      return `${name}`;
    },
    getInvoiceOptionsJson() {
      this.$Progress.start();
      axios
        .get("/invoices/create/json")
        .then((response) => {
          // console.log(response.data);
          this.items = response.data.items;
          this.customers = response.data.customers;
          // this.form.selected_customer = response.data.customer;
          this.isLoading = false;
          this.$Progress.finish();
        })
        .catch((error) => {
          this.isLoading = false;
          this.$Progress.fail();
        });
    },
    nameWithCode({ name, customer_code }) {
      if (name && customer_code) {
        return `${name} — [${customer_code}]`;
      } else {
        return "Search or select";
      }
    },
    imageUrl(image_name) {
      if (image_name) {
        return root_url + `/${image_name}`;
      }
    },
    playSound(sound) {
      if (sound) {
        var audio = new Audio(sound);
        audio.play();
      }
    },
    addProductToSale(product) {
      //console.log(product)
      this.playSound(root_url + "/assets/beep-timber.mp3");

      if (this.isEmpty(this.form.selected_item)) {
        this.form.selected_item = product;
      }

      //if items have been added to the sale list
      if (this.item_invoices.length > 0) {
        let found_product = this.item_invoices.find(
          (product_sale) => product_sale.id == product.id
        );
        if (!found_product) {
          this.item_invoices.push({
            id: product.id,
            item_img: product.item_img,
            name: product.name,
            item_price: product.item_price,
            qty: 1,
            stock_level: product.qty - 1,
            stock_level_initial: product.qty,
          });
        } else {
          this.item_invoices.forEach((product_sale, index) => {
            if (product_sale.id == product.id) {
              this.item_invoices[index].qty++;
              this.item_invoices[index].stock_level--;
            }
          });
        }
      }
      //else if no product has been added then add it
      else {
        this.item_invoices.push({
          id: product.id,
          item_img: product.item_img,
          name: product.name,
          item_price: product.item_price,
          qty: 1,
          stock_level: product.qty - 1,
          stock_level_initial: product.qty,
        });
      }
    },
    subTractQty(product_index) {
      if (this.item_invoices[product_index].qty > 1) {
        this.item_invoices[product_index].qty--;
        this.item_invoices[product_index].stock_level++;
      }
    },
    addQty(product_index) {
      if (this.item_invoices[product_index].qty >= 0) {
        this.item_invoices[product_index].qty++;
        this.item_invoices[product_index].stock_level--;
      }
    },
    deleteProductSale(index) {
      var prod_sale = this.item_invoices[index];

      //set the product qty to its initial qty
      let found_product = this.items.find(
        (product_sale) => product_sale.id == prod_sale.id
      );

      if (found_product) {
        this.items[this.items.indexOf(found_product)].qty =
          prod_sale.stock_level_initial;
      }
      this.item_invoices.splice(index, 1);
    },
    subTotal(index) {
      return (
        Math.round(
          this.item_invoices[index].item_price *
            this.item_invoices[index].qty *
            100
        ) / 100
      ).toFixed(2);
    },
    openPayWithModal(payment_type) {
      this.playSound(root_url + "/assets/beep-07.mp3");
      this.form.amount_to_pay = this.grandTotal;

      $("#confirmSaleModal").modal("show");
    },
    //openCustomerAddModal() {},
    openCustomersCreateModal() {
      $("#customersCreateModal").modal("show");
    },
    openItemCreateModal() {
      $("#itemsCreateModal").modal("show");
    },

    async generateInvoice() {

      
      this.form.total = this.total;
      this.form.grandTotal = this.grandTotal;
      
      this.form.item_invoices = [];
      this.form.item_invoices = this.item_invoices;
      
      let timerInterval;
      swal
        .fire({
          title: "Please Wait",
          html: "Generating Invoice",
          // timer: 2000,
          timerProgressBar: true,
          didOpen: () => {
            swal.showLoading();
            axios
              .post("/invoices", this.form)
              .then((response) => {
                setTimeout(() => {
                  window.location.href = response.data.url;
                }, 1500);
              })
              .catch((error) => {});
          },
          willClose: () => {
            clearInterval(timerInterval);
          },
        })
        .then((result) => {
          /* Read more about handling dismissals below */
          if (result.dismiss === swal.DismissReason.timer) {
            console.log("I was closed by the timer");
          }
        });
    },

    finalizeSaleSubmit() {
      this.$Progress.start();
      this.finalize_modal_saving = true;
      this.form.total = this.total;
      this.form.grandTotal = this.grandTotal;
      this.form.discount_percentage = this.form.selected_customer.discount_percentage;
      this.form.change = this.changeAmount;
      this.form.product_qty = this.totalQty;
      this.form.bonus_bags_qty = this.bonusBagsQty;
      this.form.item_invoices = [];
      this.form.item_invoices = this.item_invoices;
      this.form
        .post("/sales/pos/store")
        .then((response) => {
          this.isLoadingSaving = false;
          this.$Progress.finish();
          this.playSound(root_url + "/assets/beep-07.mp3");
          this.finalize_modal_saving = false;
          $("#confirmSaleModal").modal("hide");
          toast.fire({
            icon: "success",
            title: response.data.message,
          });

          window.location.href = response.data.url;
          this.isSaving = false;
          this.resetForm();
        })
        .catch((error) => {
          this.isSaving = false;
          this.finalize_modal_saving = false;
          this.$Progress.fail();
        });
    },
    customerSaved(customer) {
      this.customers.push({
        id: customer.id,
        name: customer.name,
      });
      this.form.selected_customer = customer;
    },
    itemSaved(item) {
      this.items.push(item);
      this.itemSelected(item);
    },
    clearPaymentAmount() {
      this.form.cash_payment = "";
      this.form.momo_payment = "";
    },
    resetForm() {
      this.form.selected_customer = "";
      this.form.selected_item = "";
      this.form.momo_number = "";
      this.form.selected_payment_option = "";
      this.form.paid_amount = "";
      this.form.amount_to_pay = "";
      this.form.sale_note = "";
      this.form.change = 0.0;
      this.form.cash_payment = "";
      this.form.momo_payment = "";
      this.form.sale_date = this.current_date;
      this.item_invoices = [];
    },
    editQty(index, qty) {
      // console.log("index: " + index + " qty: " + qty)
      if (qty && qty >= 1) {
        this.item_invoices[index].qty = parseInt(qty);
      } else {
        this.item_invoices[index].qty = 0;
        this.item_invoices[index].stock_level = this.item_invoices[
          index
        ].stock_level_initial;
      }
    },
    itemSelected(item) {
      if (item) {
        this.addProductToSale(item);
        const index = this.items.indexOf(item);

        //reduce item qty by 1
        this.items[index].qty--;
        //take item out of items list
        if (index > -1) {
          // this.items.splice(index, 1);
          this.form.selected_item = "";
        }
      }
    },
  },
  computed: {
    total: function () {
      var the_total = 0;
      this.item_invoices.forEach(function (item) {
        the_total += item.item_price * item.qty;
      });
      // return  the_total;
      return (Math.round(the_total * 100) / 100).toFixed(2);
    },
    tax: function () {
      return this.total * 1;
    },
    grandTotal: function () {
      var grand_total = 0;
      this.item_invoices.forEach((item) => {
        //exclude the bonus bags from grand total calculation
        let the_product_price = item.item_price;
        grand_total += the_product_price * item.qty;
      });
      // return  grand_total;
      return (Math.round(grand_total * 100) / 100).toFixed(2);
    },
    customerDiscount: function () {
      if (this.form.selected_customer) {
        return this.form.selected_customer.discount_percentage;
      }
      return `0.00`;
    },
    customerRate: function () {
      if (this.form.selected_customer) {
        return this.form.selected_customer.product_rate;
      }
      return `2.3 `;
    },
    changeAmount: function () {
      return this.to_2dp(
        this.to_2dp(parseFloat(this.form.cash_payment)) +
          this.to_2dp(parseFloat(this.form.momo_payment)) -
          this.to_2dp(parseFloat(this.grandTotal))
      );
    },
    totalQty: function () {
      //this total qty excludes the bonus bags sold
      var total_qty = 0;
      this.item_invoices.forEach((item) => {
        //exclude the bonus bags from total qty calculation
        let the_product_qty = item.qty;
        total_qty += the_product_qty;
      });
      return total_qty;
    },
    bonusBagsQty: function () {
      var bonus_qty = 0;
      this.item_invoices.forEach((item) => {
        //exclude the bonus bags from total qty calculation
        let the_product_qty = 0;
        bonus_qty += the_product_qty;
      });
      return bonus_qty;
    },
    can_generate_invoice: function () {
      return !(this.item_invoices.length >= 1) || !this.form.selected_customer || !this.form.invoice_date;
    },
  },
};
</script>
<style scoped>
.pos-side {
  flex: 3;
}
.product-list {
  flex: 1;
  background-color: rgba(86, 61, 124, 0.15);
  border: 1px solid rgba(86, 61, 124, 0.15);
  min-height: 350px;
}
.product-item {
  cursor: pointer;
}
.table th,
.table td {
  padding: 1rem;
}
.qty-number {
  padding: 0 0.75rem;
  max-width: 70px;
  text-align: center;
}
table#posTable {
  min-height: 100px;
  font-size: 20px;
}
.payment-amount {
  background-color: #d6deff;
  margin-top: 10px;
  text-align: center;
  padding-top: 10px;
  padding-bottom: 10px;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>