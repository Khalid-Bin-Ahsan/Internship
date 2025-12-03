import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css'
import App from './App.jsx'
import { createBrowserRouter } from "react-router";
import { RouterProvider } from "react-router/dom";
import Root from './Root/Root.jsx';
import Home from './Home/Home.jsx';
import Portfolio from './portfolio/portfolio.jsx';
import RiskAnalysis from './RiskAnalysis/RiskAnalysis.jsx';
import Market from './Market/Market.jsx';

const router = createBrowserRouter([
  {
    path: "/",
    element: <Root></Root>,
    children:[
      {
        path:'/',
        element:<Home></Home>
      },
      {
        path:'/Portfolio',
        element:<Portfolio></Portfolio>
      },
      
      {
        path:'/RiskAnalysis',
        element:<RiskAnalysis></RiskAnalysis>
      },
      {
        path:'/Market',
        element:<Market></Market>
      }
    ]
  },
]);


createRoot(document.getElementById('root')).render(
  <StrictMode>
    <RouterProvider router={router} />,
  </StrictMode>,
)
