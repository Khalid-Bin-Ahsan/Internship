import React from "react";
import Home from "../Home/Home";
import Navbar from "../Header/Navbar";
import Footer from "../Footer/Footer";
import { Outlet } from "react-router";
const Root =()=>{
    return(
        <div className='max-w-6xl mx-auto ' >
         <Navbar> </Navbar>
         <Outlet></Outlet>
         <Footer></Footer>
        
        </div>
   
    );
};
export default Root;
