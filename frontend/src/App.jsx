import { Stack } from "@mui/material"
import { Route, Routes } from "react-router-dom"
import Dashboard from "./pages/dashboard"
import Login from "./pages/login"
import Products from "./pages/Products"
import Cancel from "./pages/Cancel"
import Success from "./pages/Success"

const App = () => {
  return (
    <Stack>
      <Routes>
        <Route path='/' element={<Login />} />
        <Route path='products/*' element={<Protected />}>
          <Route index element={<Plan />} />
          <Route path='dashboard' element={<Dashboard />} />
          <Route path='payment/success' element={<Success />} />
          <Route path='cancel' element={<Cancel />} />
        </Route>
      </Routes>
    </Stack>
  );
};

export default App