import Category from "../models/category.model.js";
import Product from "../models/product.model.js";


//login admin
export const adminLogin = async (req, res) => {
    try {
        const { userEmail, userPassword } = req.body;

        // Form validation
        if (!userEmail || !userPassword) {
            return res.status(400).json({
                success: false,
                message: "All fields are required!"
            });
        }

        // Check user
        const user = await User.findOne({ userEmail })
            .select("+userPassword");

        if (!user) {
            return res.status(401).json({
                success: false,
                message: "Invalid Credentials"
            });
        }

        // Compare password
        const passwordMatch = await bcrypt.compare(
            userPassword,
            user.userPassword
        );

        if (!passwordMatch) {
            return res.status(401).json({
                success: false,
                message: "Invalid Credentials"
            });
        }

        // Create token
        const token = jwt.sign(
            {
                id: user._id,
                userRole: user.userRole
            },
            process.env.JWT_SECRET_KEY,
            {
                expiresIn: "2d"
            }
        );

        // Create cookie
        res.cookie("instantShopper", token, {
            httpOnly: true,
            secure: true,
            sameSite: "None",
            maxAge: 2 * 24 * 60 * 60 * 1000, // 2 days
            path: "/"
        });

        return res.status(200).json({
            success: true,
            message: `Welcome ${user.userName}`,
            token
        });

    } catch (error) {
        console.error(error);

        return res.status(500).json({
            success: false,
            message: "Something went wrong while logging in!"
        });
    }
};

//create product
export const createProduct = async (req, res) => {
    try {
        const {
            productName,
            productSlug,
            productSpecification,
            productCategory
        } = req.body;

        // form validation
        if (!productName || !productSlug || !productSpecification || !productCategory) {
            return res.status(400).json({
                success: false,
                message: "All product details are required!"
            });
        }

        // image validation
        if (!req.file) {
            return res.status(400).json({
                success: false,
                message: "Select at least one image"
            });
        }

        // check if category exists
        const categoryExists = await Category.findById(productCategory);
        if (!categoryExists) {
            return res.status(404).json({
                success: false,
                message: "Product category not found"
            });
        }

        // check duplicate slug
        const existingProduct = await Product.findOne({ productSlug });
        if (existingProduct) {
            return res.status(409).json({
                success: false,
                message: "Product slug already exists"
            });
        }

        // create product
        const newProduct = new Product({
            productName,
            productSlug,
            productSpecification,
            productCategory,
            productImage: req.file.path
        });

        await newProduct.save();

        return res.status(201).json({
            success: true,
            message: "Product successfully created!",
            data: newProduct
        });

    } catch (error) {
        return res.status(500).json({
            success: false,
            message: "Something went wrong while creating product",
            error: error.message
        });
    }
};