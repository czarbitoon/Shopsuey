import { Stack } from "@mui/material"
import { Route, Routes } from "react-router-dom"
import Dashboard from "./pages/Dashboard"
import Login from "./pages/Login"
import Product from "./pages/Product"
import Cancel from "./pages/Cancel"
import Protected from './pages/Protected';
import Success from "./pages/Success"

const App = () => {
  return (
    <Stack>
      <Routes>
        <Route path='/' element={<Login />} />
        <Route path='products/*' element={<Protected />}>
          <Route index element={<Product />} />
          <Route path='dashboard' element={<Dashboard />} />
          <Route path='payment/success' element={<Success />} />
          <Route path='cancel' element={<Cancel />} />
        </Route>
      </Routes>
    </Stack>
  );
};

export default App

