# NativeDriver
## A native filesystem driver

_Copyright (c) 2015, Matthew J. Sahagian_.
_Please reference the LICENSE.md file at the root of this distribution_

#### Namespace

`Affinity`

#### Imports

<table>

	<tr>
		<th>Alias</th>
		<th>Namespace / Class</th>
	</tr>
	
	<tr>
		<td>Flourish</td>
		<td>Dotink\Flourish</td>
	</tr>
	
</table>

#### Authors

<table>
	<thead>
		<th>Name</th>
		<th>Handle</th>
		<th>Email</th>
	</thead>
	<tbody>
	
		<tr>
			<td>
				Matthew J. Sahagian
			</td>
			<td>
				mjs
			</td>
			<td>
				msahagian@dotink.org
			</td>
		</tr>
	
	</tbody>
</table>

## Properties

### Instance Properties
#### <span style="color:#6a6e3d;">$directory</span>

The directory to load from




## Methods

### Instance Methods
<hr />

#### <span style="color:#3e6a6e;">__construct()</span>

Create a new driver

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$directory
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				The directory to load from (will load recursively)
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">load()</span>

Load actions and configs using the driver

##### Details

This should load the default environment in addition to environments provided in
the `$environments` parameter.

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$engine
			</td>
			<td>
									<a href="./Engine.md">Engine</a>
				
			</td>
			<td>
				The engine to which loaded configs/actions will be added
			</td>
		</tr>
					
		<tr>
			<td>
				$environments
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				A comma separated list of additional environments to load
			</td>
		</tr>
					
		<tr>
			<td>
				$context
			</td>
			<td>
									<a href="http://php.net/language.types.array">array</a>
				
			</td>
			<td>
				The context to be made available when loading configs and actions
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">scanDirectory()</span>

Scans an individual directory and adds configs or actions from it to the engine

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$directory
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				The directory to scan
			</td>
		</tr>
					
		<tr>
			<td>
				$base
			</td>
			<td>
									stirng				
			</td>
			<td>
				The base directory to exclude from keys
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">retrieve()</span>

Retrieve the action or config from a given file

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$target_file
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				The file to load the action or config from
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			mixed
		</dt>
		<dd>
			An ActionInterface or ConfigInterface object
		</dd>
	
</dl>






