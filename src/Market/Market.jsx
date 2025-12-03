import React from "react";
const Market =()=>{
    return(
        <div>
        <div className="card bg-base-200 text-base-content w-full mt-4">
  <div className="card-body">
    <h2 className="card-title text-3xl">Market Overview</h2>

    {/* Search and Filters */}
    <div className="flex flex-wrap items-center gap-4 mt-4">
      <input
        type="text"
        placeholder="Search for a token..."
        className="input input-bordered w-full sm:w-64"
      />
      <div className="btn-group">
        <button className="btn btn-sm btn-outline">DeFi</button>
        <button className="btn btn-sm btn-outline">NFTs</button>
        <button className="btn btn-sm btn-outline btn-success">Top Gainers</button>
      </div>
    </div>

    {/* Table */}
    <div className="overflow-x-auto mt-6">
      <table className="table table-zebra">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Price</th>
            <th>24H %</th>
            <th>Market Cap</th>
            <th>Volume (24H)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Bitcoin (BTC)</td>
            <td>$68,123.45</td>
            <td className="text-success">+2.5%</td>
            <td>$1.34T</td>
            <td>$25.5B</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Ethereum (ETH)</td>
            <td>$3,540.12</td>
            <td className="text-error">-1.2%</td>
            <td>$425.1B</td>
            <td>$18.2B</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Solana (SOL)</td>
            <td>$165.78</td>
            <td className="text-success">+5.8%</td>
            <td>$74.3B</td>
            <td>$3.1B</td>
          </tr>
          <tr>
            <td>4</td>
            <td>BNB (BNB)</td>
            <td>$590.50</td>
            <td className="text-success">+0.5%</td>
            <td>$87.0B</td>
            <td>$1.5B</td>
          </tr>
          <tr>
            <td>5</td>
            <td>Ripple (XRP)</td>
            <td>$0.52</td>
            <td className="text-error">-3.1%</td>
            <td>$28.9B</td>
            <td>$1.1B</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
        

        </div>
   
    );
};
export default Market;
