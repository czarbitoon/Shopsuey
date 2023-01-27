import React from 'react';
import { Outlet } from 'react-router-dom';
import { redirect } from "react-router-dom";
const Protected = () => {
  const auth = localStorage.getItem('token');
  return auth ? <Outlet /> : redirect ('/');
};

export default Protected;



