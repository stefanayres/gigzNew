import React from 'react';
import { NavLink } from 'react-router-dom';

const Nav = () => {


  return(
    <div>

      <NavLink to="/" >Home</NavLink>
      <NavLink to="/About" >About</NavLink>
      <NavLink to="/Login" >Log In</NavLink>
      <NavLink to="/Register" >Sign up</NavLink>

    </div>
  );
}
export default Nav;