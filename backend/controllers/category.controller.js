import Category from "../models/category.model.js";

export const createCategory = async (req, res) => {
    try {
        const { categoryName } = req.body;

        // Validate input
        if (!categoryName || categoryName.trim() === "") {
            return res.status(400).json({
                success: false,
                message: "Category Name cannot be empty!"
            });
        }

        // Normalize input to prevent  duplicates like "Tech" and "tech"
        const formattedName = categoryName.trim().toLowerCase();

        // Check if category already exists
        const categoryExists = await Category.findOne({
            categoryName: formattedName
        });

        if (categoryExists) {
            return res.status(409).json({
                success: false,
                message: "Category already exists!"
            });
        }

        // Create new category
        const newCategory = new Category({
            categoryName: formattedName
        });

        await newCategory.save();

        return res.status(201).json({
            success: true,
            message: "New category created successfully!",
            category: newCategory
        });

    } catch (error) {
        console.error("Create Category Error:", error);

        return res.status(500).json({
            success: false,
            message: "Something went wrong while creating category!"
        });
    }
};