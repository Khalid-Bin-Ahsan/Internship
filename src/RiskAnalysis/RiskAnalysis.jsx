import React from "react";
const RiskAnalysis =()=>{
    return(
       <div>
        <h2 className="text-3xl font-bold mt-4">Risk Analysis&Prediction</h2>
         <div className="mt-4">
        
            <div className="card bg-base-200 text-base-content w-full ">
  <div className="card-body">
    <div className="flex justify-between items-center">
      <h2 className="card-title">Token Price Prediction</h2>
      <div className="btn-group">
        <button className="btn btn-sm btn-success">LSTM</button>
        <button className="btn btn-sm btn-info">GRU</button>
      </div>
    </div>
    <p className="text-sm opacity-70">BTC - $65,432.10 (+2.5% over 90 days)</p>

    {/* Chart Placeholder */}
    <div className="mt-6 bg-base-300 rounded-box p-4">
      <svg viewBox="0 0 100 40" className="w-full h-40">
        {/* Axes */}
        <line x1="5" y1="35" x2="95" y2="35" stroke="currentColor" className="opacity-30" />
        <line x1="5" y1="5" x2="5" y2="35" stroke="currentColor" className="opacity-30" />

        {/* Historical Price Line */}
        <polyline fill="none" stroke="hsl(var(--b))" strokeWidth="1.5"
          points="5,30 20,28 35,26 50,24 65,22 80,20 95,18" />

        {/* LSTM Prediction */}
        <polyline fill="none" stroke="hsl(var(--wa))" strokeWidth="1.5"
          points="80,20 85,19 90,18 95,17" />

        {/* GRU Prediction */}
        <polyline fill="none" stroke="hsl(var(--in))" strokeWidth="1.5"
          points="80,20 85,21 90,22 95,23" />
      </svg>
      <p className="mt-2 text-xs text-neutral-content opacity-60">Historical and predicted price trends</p>
    </div>
  </div>
</div>
        


<div className="flex gap-4 mt-4">

<div className="card bg-base-200 text-base-content w-full max-w-4xl mx-auto">
  <div className="card-body">
    <h2 className="card-title">Wallet Clustering Analysis</h2>
    <p className="text-sm opacity-70">52 Clusters Identified</p>

    {/* Network Graph Placeholder */}
    <div className="mt-6 bg-base-300 rounded-box p-4 flex items-center justify-center h-64">
      <svg viewBox="0 0 100 100" className="w-full h-full">
        {/* Simulated nodes and edges */}
        <circle cx="50" cy="50" r="2" fill="hsl(var(--in))" />
        <circle cx="30" cy="30" r="1.5" fill="hsl(var(--su))" />
        <circle cx="70" cy="30" r="1.5" fill="hsl(var(--wa))" />
        <circle cx="30" cy="70" r="1.5" fill="hsl(var(--er))" />
        <circle cx="70" cy="70" r="1.5" fill="hsl(var(--pr))" />
        <line x1="50" y1="50" x2="30" y2="30" stroke="currentColor" strokeWidth="0.5" />
        <line x1="50" y1="50" x2="70" y2="30" stroke="currentColor" strokeWidth="0.5" />
        <line x1="50" y1="50" x2="30" y2="70" stroke="currentColor" strokeWidth="0.5" />
        <line x1="50" y1="50" x2="70" y2="70" stroke="currentColor" strokeWidth="0.5" />
      </svg>
    </div>

    {/* Footer Actions */}
    <div className="mt-6 flex gap-3 justify-end">
      <button className="btn btn-info">View Cluster Details</button>
      <button className="btn btn-outline">Export Graph</button>
    </div>
  </div>
</div>
<div className="card bg-base-200 text-base-content w-full max-w-md mx-auto">
  <div className="card-body items-center text-center">
    <h2 className="card-title">Portfolio Risk Score</h2>
    <p className="text-sm opacity-70">Medium Risk</p>

    {/* Circular Gauge */}
    <div
      className="radial-progress text-warning mt-4"
      style={{
        '--value': 55,
        '--size': '6rem',
        '--thickness': '0.8rem',
      }}
    >
      55
    </div>

    {/* Risk Factors */}
    <div className="mt-6 w-full">
      <div className="grid grid-cols-1 gap-3">
        <div className="flex justify-between items-center px-4 py-2 bg-base-100 rounded-box">
          <span className="font-semibold">Volatility Risk</span>
          <span className="badge badge-error">High</span>
        </div>
        <div className="flex justify-between items-center px-4 py-2 bg-base-100 rounded-box">
          <span className="font-semibold">Centralization Risk</span>
          <span className="badge badge-success">Low</span>
        </div>
        <div className="flex justify-between items-center px-4 py-2 bg-base-100 rounded-box">
          <span className="font-semibold">Market Sentiment</span>
          <span className="badge badge-warning">Medium</span>
        </div>
        <div className="flex justify-between items-center px-4 py-2 bg-base-100 rounded-box">
          <span className="font-semibold">Liquidity Risk</span>
          <span className="badge badge-success">Low</span>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
        </div>
       </div>
   
    );
};
export default RiskAnalysis;
