import { useState } from "react";
import axios from "axios";
import { toast } from "react-toastify";

const Login = () => {

    const [userEmail, setUserEmail] = useState("");
    const [userPassword, setUserPassword] = useState("");
    const [loading, setLoading] = ("");

    const handleRegister = async(e)=>{
        e.preventDefault();
        try
        {
            const res = await axios.post("http://localhost:3000/api/auth/login", 
            {
             userEmail, 
             userPassword
            }, {
                withCredentials: true
            });
            //console.log(res);
            if (res.data.success) 
            {
                toast.success(res.data.message);
            } 
            else 
            {
                toast.error(res.data.message);
            }
        }
        catch (error) 
        {
            //console.log(error);
            toast.error(
                error.response?.data?.message || error.message || "Something went wrong"
            );
        }
        finally{
            setUserEmail: "";
            setUserPassword: "";
        }
    }

    return (
        <div className="container mt-5">
            <div className="shadow-lg">
                <form action="" onSubmit={handleRegister}>
                    <div className="row">
                        <div className="col-md-6">
                            <img
                                src="/authPages.jpg"
                                alt="Authentication"
                                className="img-fluid h-100 w-100"
                                style={{
                                    objectFit: "cover"
                                }}
                            />
                        </div>

                        <div className="col-md-5 p-5">
                            <h3 className="text-center text-muted mb-4">
                                Login
                            </h3>
                            <p className="text-center text-muted">
                                Unlock a new World!
                            </p>

                            <div className="form-floating mb-5">
                                <input
                                    type="email"
                                    className="form-control"
                                    id="floatingInput"
                                    placeholder="johndoe@mail.com"
                                    value={userEmail}
                                    onChange={(e)=>setUserEmail(e.target.value)}
                                />
                                <label htmlFor="floatingInput">
                                    Email address
                                </label>
                            </div>

                            <div className="form-floating mb-5">
                                <input
                                    type="password"
                                    className="form-control"
                                    id="floatingPassword"
                                    placeholder="Password"
                                    value={userPassword}
                                    onChange={(e)=>setUserPassword(e.target.value)}
                                />
                                <label htmlFor="floatingPassword">
                                    Password
                                </label>
                            </div>
                            <button
                                className="btn btn-primary fw-bold w-100 mb-4"
                                disabled={loading}
                                >
                                {loading ? (
                                    <>
                                    <span className="spinner-border spinner-border-sm me-2"></span>
                                    Signing In...
                                    </>
                                ) : (
                                    "Sign In"
                                )}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Login;