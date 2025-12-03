import React from "react";
const Portfolio =()=>{
    return(
       <div>
        <h2 className="text-3xl font-bold mt-4">My Growth Portfolio</h2>
        <p>Manage Your Asset Allocation and explore AI-pc wered scenarios</p>
         <div className="flex flex-rows gap-4 mt-4">
            
        <div className="flex flex-col gap-4">
            <div className="card bg-base-200 text-base-content w-full max-w-md">
  <div className="card-body items-center text-center">
    <h2 className="card-title">Total Value</h2>

    <div className="mt-2">
      <div className="text-3xl font-bold tracking-tight">$1,250,430.88</div>
      <div className="text-success text-sm mt-1">+1.2%</div>
    </div>
  </div>
</div>
<div className="card bg-base-200 text-base-content w-full max-w-md">
  <div className="card-body items-center text-center">
    <h2 className="card-title">Total Value</h2>

    <div className="mt-2">
      <div className="text-3xl font-bold tracking-tight">$1,250,430.88</div>
      <div className="text-success text-sm mt-1">+1.2%</div>
    </div>
  </div>
</div>
<div className="card bg-base-200 text-base-content w-full max-w-md">
  <div className="card-body items-center text-center">
    <h2 className="card-title">Total Value</h2>

    <div className="mt-2">
      <div className="text-3xl font-bold tracking-tight">$1,250,430.88</div>
      <div className="text-success text-sm mt-1">+1.2%</div>
    </div>
  </div>
</div>





<div className="card bg-base-200 text-base-content w-full">
  <div className="card-body items-center text-center">
    <h2 className="card-title">Current Allocation</h2>
    <p className="mt-2 text-sm opacity-70">Total Allocation: 100%</p>

    <div className="mt-4 flex flex-wrap justify-center gap-4">
      <div
        className="radial-progress text-primary"
        style={{
          '--value': 46,
          '--size': '6rem',
          '--thickness': '0.8rem',
        }}
      >
        US Equities
      </div>
      <div
        className="radial-progress text-success"
        style={{
          '--value': 30,
          '--size': '6rem',
          '--thickness': '0.8rem',
        }}
      >
        Intl. Bonds
      </div>
      <div
        className="radial-progress text-warning"
        style={{
          '--value': 20,
          '--size': '6rem',
          '--thickness': '0.8rem',
        }}
      >
        Real Estate
      </div>
      <div
        className="radial-progress text-info"
        style={{
          '--value': 10,
          '--size': '6rem',
          '--thickness': '0.8rem',
        }}
      >
        Crypto
      </div>
    </div>
  </div>
</div>


        </div>

<div className="flex flex-col gap-4">

    <div className="card bg-base-200 text-base-content w-full max-w-2xl mx-auto">
  <div className="card-body">
    <h2 className="card-title">Asset Allocation</h2>
    <p className="text-sm opacity-70">Adjust your portfolio distribution</p>

    {/* US Equities */}
    <div className="mt-4">
      <label className="label justify-between">
        <span className="label-text font-semibold">US Equities</span>
        <span className="text-sm font-bold">48%</span>
      </label>
      <input type="range" min={0} max={100} value={48} className="range range-primary" />
    </div>

    {/* International Bonds */}
    <div className="mt-4">
      <label className="label justify-between">
        <span className="label-text font-semibold">International Bonds</span>
        <span className="text-sm font-bold">38%</span>
      </label>
      <input type="range" min={0} max={100} value={38} className="range range-success" />
    </div>

    {/* Cryptocurrency */}
    <div className="mt-4">
      <label className="label justify-between">
        <span className="label-text font-semibold">Cryptocurrency</span>
        <span className="text-sm font-bold">10%</span>
      </label>
      <input type="range" min={0} max={100} value={10} className="range range-info" />
    </div>

    {/* Footer Actions */}
    <div className="mt-6 flex gap-3 justify-end">
      <button className="btn btn-primary">Save Allocation</button>
      <button className="btn btn-outline">Reset</button>
    </div>
  </div>
</div>

<div className="card bg-base-200 text-base-content w-full max-w-2xl mx-auto">
  <div className="card-body">
    <h2 className="card-title">Current vs. Proposed Allocation</h2>
    <p className="text-sm opacity-70">Compare your existing and suggested portfolio distribution</p>

    {/* US Equities */}
    <div className="mt-4">
      <label className="label justify-between">
        <span className="label-text font-semibold">US Equities</span>
        <span className="text-sm font-bold">40%</span>
      </label>
      <progress className="progress progress-primary w-full" value={40} max={100}></progress>
    </div>

    {/* Intl. Bonds */}
    <div className="mt-4">
      <label className="label justify-between">
        <span className="label-text font-semibold">Intl. Bonds</span>
        <span className="text-sm font-bold">30%</span>
      </label>
      <progress className="progress progress-success w-full" value={30} max={100}></progress>
    </div>

    {/* Real Estate */}
    <div className="mt-4">
      <label className="label justify-between">
        <span className="label-text font-semibold">Real Estate</span>
        <span className="text-sm font-bold">20%</span>
      </label>
      <progress className="progress progress-warning w-full" value={20} max={100}></progress>
    </div>

    {/* Cryptocurrency */}
    <div className="mt-4">
      <label className="label justify-between">
        <span className="label-text font-semibold">Cryptocurrency</span>
        <span className="text-sm font-bold">10%</span>
      </label>
      <progress className="progress progress-info w-full" value={10} max={100}></progress>
    </div>
  </div>
</div>
</div>
<div className="card card-body bg-blue-500 p-6 ">
  
  <h2 className="text-2xl font-bold mb-4">AI Optimizer</h2>
  <p className="text-sm opacity-70 mb-6">Explore AI-powered investment scenarios</p>

  {/* Chart Section */}
  <div className="card bg-base-200 mb-6">
    <div className="card-body">
      <h2 className="card-title">Projected Return vs Risk</h2>
      <p className="text-sm opacity-70">Visual comparison of investment strategies</p>

      {/* Chart Placeholder */}
      <div className="mt-4 bg-base-300 rounded-box p-4">
        <svg viewBox="0 0 100 40" className="w-full h-40">
          <line x1="5" y1="35" x2="95" y2="35" stroke="currentColor" className="opacity-30" />
          <line x1="5" y1="5" x2="5" y2="35" stroke="currentColor" className="opacity-30" />
          {/* Aggressive Growth */}
          <polyline fill="none" stroke="hsl(var(--er))" strokeWidth="1.5" points="5,30 20,28 35,24 50,18 65,12 80,8 95,6" />
          {/* Balanced */}
          <polyline fill="none" stroke="hsl(var(--pr))" strokeWidth="1.5" points="5,31 20,30 35,28 50,25 65,22 80,19 95,17" />
          {/* Conservative */}
          <polyline fill="none" stroke="hsl(var(--su))" strokeWidth="1.5" points="5,32 20,31 35,30 50,29 65,27 80,26 95,25" />
        </svg>
      </div>
    </div>
  </div>

  {/* Strategy Cards */}
  <div className="flex flex-col gap-4">
    {/* Aggressive Growth */}
    <div className="card bg-base-200">
      <div className="card-body">
        <div className="flex justify-between items-center">
          <h3 className="card-title">Aggressive Growth</h3>
          <div className="badge badge-error badge-outline">High Risk</div>
        </div>
        <div className="grid grid-cols-2 gap-2 mt-2">
          <div className="stat">
            <div className="stat-title">Projected Return</div>
            <div className="stat-value text-error">+18.2%</div>
          </div>
          <div className="stat">
            <div className="stat-title">Projected Risk</div>
            <div className="stat-value">8.5</div>
          </div>
        </div>
        <div className="card-actions justify-end">
          <button className="btn btn-error">Apply Suggestion</button>
        </div>
      </div>
    </div>

    {/* Balanced (Current) */}
    <div className="card bg-base-200 border border-primary">
      <div className="card-body">
        <div className="flex justify-between items-center">
          <h3 className="card-title">Balanced</h3>
          <div className="badge badge-primary">Current</div>
        </div>
        <div className="grid grid-cols-2 gap-2 mt-2">
          <div className="stat">
            <div className="stat-title">Projected Return</div>
            <div className="stat-value text-primary">+12.5%</div>
          </div>
          <div className="stat">
            <div className="stat-title">Projected Risk</div>
            <div className="stat-value">6.8</div>
          </div>
        </div>
        <div className="card-actions justify-end">
          <button className="btn btn-primary btn-outline">Already Applied</button>
        </div>
      </div>
    </div>

    {/* Conservative */}
    <div className="card bg-base-200">
      <div className="card-body">
        <div className="flex justify-between items-center">
          <h3 className="card-title">Conservative</h3>
          <div className="badge badge-success badge-outline">Low Risk</div>
        </div>
        <div className="grid grid-cols-2 gap-2 mt-2">
          <div className="stat">
            <div className="stat-title">Projected Return</div>
            <div className="stat-value text-success">+7.8%</div>
          </div>
          <div className="stat">
            <div className="stat-title">Projected Risk</div>
            <div className="stat-value">4.2</div>
          </div>
        </div>
        <div className="card-actions justify-end">
          <button className="btn btn-success">Apply Suggestion</button>
        </div>
      </div>
    </div>
  </div>


</div>

        </div>
       </div>
   
    );
};
export default Portfolio;
