import mongoose from "mongoose";

const productSchema = new mongoose.Schema({
    productName: {
        type: String,
        required: true,
        trim: true
    },
    productSlug: {
        type: String,
        required: true,
    },
    productSpecification: {
        type: String,
        required: true,
    },
    productImage: {
        type: String,
        required: true,
    },
    productCategory: {
        type: mongoose.Schema.Types.ObjectId,
        ref: "Category",
        required: true
    }
});

const Product = mongoose.model("Product", productSchema);

export default Product;