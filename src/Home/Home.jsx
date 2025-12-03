import React from "react";
const Home =()=>{
    return(
        <div>
        <div className="flex justify-between mt-4 ">
            <div class="stats w-94 bg-base-200 text-base-content">
  <div class="stat">
    <div class="stat-title">Total Portfolio Value</div>
    <div class="stat-value">$1,234,567.89</div>
  </div>
</div>
<div class="stats w-94 bg-base-200 text-base-content">
  <div class="stat">
    <div class="stat-title">Total Portfolio Value</div>
    <div class="stat-value">$1,234,567.89</div>
  </div>
</div>
<div class="stats w-94 bg-base-200 text-base-content">
  <div class="stat">
    <div class="stat-title">Total Portfolio Value</div>
    <div class="stat-value">$1,234,567.89</div>
  </div>
</div>
        </div>


<div className="flex mt-4 gap-4">


<div className="card bg-base-200 text-base-content w-full">
  <div className="card-body">
    <div className="flex items-start justify-between">
      <div>
        <h2 className="card-title">Portfolio Performance</h2>
        <div className="stats shadow mt-3">
          <div className="stat">
            <div className="stat-title">Current Value</div>
            <div className="stat-value">$1,234,567.89</div>
            <div className="stat-desc text-success">vs Prev: +23.45%</div>
          </div>
        </div>
      </div>

      {/* Time range selector */}
      <div className="btn-group">
        <button className="btn btn-sm">1D</button>
        <button className="btn btn-sm">1W</button>
        <button className="btn btn-sm">1M</button>
        <button className="btn btn-sm btn-active">1Y</button>
      </div>
    </div>

    {/* Simple inline chart (SVG placeholder) */}
    <div className="mt-6">
      <div className="bg-base-300 rounded-box p-4">
        <svg viewBox="0 0 100 30" className="w-full h-24">
          {/* Axis baseline */}
          <line x1="0" y1="28" x2="100" y2="28" stroke="currentColor" className="opacity-30" />
          {/* Trend line */}
          <polyline
            fill="none"
            stroke="hsl(var(--su))"
            strokeWidth="1.5"
            points="
              0,22 8,24 16,20 24,18 32,21 40,15
              48,17 56,12 64,14 72,10 80,13 88,9 96,11 100,8
            "
          />
        </svg>
      </div>
    </div>
  </div>
</div>
    <div className=" flex flex-col gap-4">
        <div class="card bg-base-200 text-base-content w-full">
  <div class="card-body">
    <h2 class="card-title">Top 5 Volatile Tokens</h2>
    <ul class="mt-4 space-y-3">
      <li class="flex items-center justify-between">
        <span class="font-bold">1. BTC</span>
        <span>$67,123.45</span>
        <span class="text-success font-semibold">+2.15%</span>
      </li>
      <li class="flex items-center justify-between">
        <span class="font-bold">2. ETH</span>
        <span>$3,456.78</span>
        <span class="text-error font-semibold">-1.80%</span>
      </li>
      <li class="flex items-center justify-between">
        <span class="font-bold">3. SOL</span>
        <span>$145.28</span>
        <span class="text-success font-semibold">+5.50%</span>
      </li>
      <li class="flex items-center justify-between">
        <span class="font-bold">4. DOGE</span>
        <span>$0.158</span>
        <span class="text-error font-semibold">-3.25%</span>
      </li>
      <li class="flex items-center justify-between">
        <span class="font-bold">5. ADA</span>
        <span>$0.45</span>
        <span class="text-success font-semibold">+0.95%</span>
      </li>
    </ul>
  </div>
</div>
<div className="card bg-base-200 text-base-content w-full">
  <div className="card-body items-center text-center">
    <h2 className="card-title">Asset Allocation</h2>
    <div className="mt-4 flex flex-wrap justify-center gap-4">
      {/* Circular chart segments */}
      <div className="radial-progress text-primary" style={{ '--value': 66, '--size': '8rem', '--thickness': '1rem' }}>
        Crypto
      </div>
      <div className="radial-progress text-success" style={{ '--value': 30, '--size': '8rem', '--thickness': '1rem' }}>
        Stocks
      </div>
      <div className="radial-progress text-error" style={{ '--value': 10, '--size': '8rem', '--thickness': '1rem' }}>
        Cash
      </div>
    </div>
    <p className="mt-4 text-sm opacity-70">Total Assets: 5 units</p>
  </div>
</div>
    </div>
</div>
        </div>
   
    );
};
export default Home;
