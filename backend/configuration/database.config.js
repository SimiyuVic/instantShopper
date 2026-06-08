import mongoose from "mongoose";

export const connectDB = async()=>{
    try
    {
      const conn = await mongoose.connect(process.env.MONGO_URL);
      console.log("MongoDb Connected!")
    }
    catch(error)
    {
        console.log(error);
        console.log("Failed to connect to MongoDB");
    }
} 