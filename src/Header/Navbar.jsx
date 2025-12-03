import React from "react";
import logo from "../assets/bs.png"
import { Link } from "react-router";
const Navbar =()=>{
    return(
       <div className="navbar bg-base-100 shadow-sm">
  <div className="flex-1">
    <a className="btn btn-ghost text-xl"><img className="w-[60px] h-[60px]" src={logo} alt="" /> BlockSight</a>
  </div>
  <div className="flex-none">
    <ul className="menu menu-horizontal px-1">
      <li><Link to={"/"}>Deshboard</Link></li>
      <li>
       <Link to={"/Portfolio"}>Portfolio</Link></li>
      <li><Link to={"/Market"}>Market</Link></li>
      <li><Link to={"/RiskAnalysis"}>Risk Analysis</Link></li>
      <li><button className="btn">LogIn/Register</button></li>
    </ul>
  </div>
</div>
   
    );
};
export default Navbar;
